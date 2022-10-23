<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Domain\Authentication\Entity\User;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * class AbstractCrudController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 *
 * @method User getUser()
 */
#[IsGranted('IS_AUTHENTICATED_FULLY')]
abstract class AbstractCrudController extends AbstractController
{
    use DeleteCsrfTrait;

    protected const ROUTE_PREFIX = 'administration_';
    protected const DOMAIN = 'authentication';
    protected const ENTITY = 'user';

    protected readonly Request $request;

    public function __construct(
        protected readonly MessageBusInterface $commandBus,
        protected readonly TranslatorInterface $translator,
        protected readonly LoggerInterface $logger,
        protected readonly RequestStack $requestStack,
        protected readonly PaginatorInterface $paginator
    ) {
        if (null !== $this->requestStack->getCurrentRequest()) {
            $this->request = $this->requestStack->getCurrentRequest();
        }
    }

    public function getViewPath(string $name): string
    {
        return sprintf('@admin/domain/%s/%s/%s.html.twig', static::DOMAIN, static::ENTITY, $name);
    }

    public function getRouteName(string $name): string
    {
        return sprintf('%s%s_%s_%s', self::ROUTE_PREFIX, static::DOMAIN, static::ENTITY, $name);
    }

    public function queryIndex(AbstractRepository $repository): Response
    {
        return $this->render(
            view: $this->getViewPath('index'),
            parameters: [
                'data' => $this->paginator->paginate(
                    target: $repository->findBy([], orderBy: [
                        'created_at' => 'DESC',
                    ]),
                    page: $this->request->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }

    public function executeCommand(object $command, ?object $row = null): Response
    {
        try {
            $this->dispatchSync($command);
            $this->addSuccessfullActionFlash('annulation du bannissement');
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        if (null !== $row && method_exists($row, 'getId')) {
            return $this->redirectSeeOther(
                route: $this->getRouteName('show'),
                params: [
                    'id' => $row->getId(),
                ]
            );
        }

        return $this->redirectSeeOther($this->getRouteName('index'));
    }

    public function executeFormCommand(object $command, string $formClass, ?object $row = null, string $view = 'new'): Response
    {
        $form = $this->createForm($formClass, $command, [
            'action' => $this->generateUrl(
                route: strval($this->request->attributes->get('_route')),
                parameters: $this->request->attributes->get('_route_params'),
            )
        ])->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessfullActionFlash();

                if (null !== $row && method_exists($row, 'getId')) {
                    return $this->redirectSeeOther(
                        route: $this->getRouteName('show'),
                        params: [
                            'id' => $row->getId(),
                        ]
                    );
                }

                return $this->redirectSeeOther($this->getRouteName('index'));
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = $this->createUnprocessableEntityResponse();
            }
        }

        return $this->renderForm(
            view: $this->getViewPath($view),
            parameters: [
                'form' => $form,
                'data' => $row,
                '_turbo_frame_target' => $this->request->headers->get('Turbo-Frame', '_top')
            ],
            response: $response ?? null
        );
    }

    public function executeDeleteCommand(object $command, object $row): Response
    {
        if ($this->isDeleteCsrfTokenValid($row, $this->request)) {
            try {
                $this->dispatchSync($command);

                if ($this->request->isXmlHttpRequest()) {
                    return new JsonResponse(null, Response::HTTP_ACCEPTED);
                }

                $this->addSuccessfullActionFlash('suppression');
            } catch (\Throwable $e) {
                if ($this->request->isXmlHttpRequest()) {
                    return new JsonResponse([
                        'message' => $this->getSafeMessageException($e),
                    ], Response::HTTP_BAD_REQUEST);
                }

                $this->addSafeMessageExceptionFlash($e);
            }
        }

        return $this->redirectSeeOther($this->getRouteName('index'));
    }
}
