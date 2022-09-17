<?php

declare(strict_types=1);

namespace Infrastructure\Administration\Symfony\Controller;

use Application\Authentication\Command\BanUserCommand;
use Application\Authentication\Command\CreateUserCommand;
use Application\Authentication\Command\DeleteUserCommand;
use Application\Authentication\Command\UnbanUserCommand;
use Application\Authentication\Command\UpdateUserCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Doctrine\Repository\UserRepository;
use Infrastructure\Authentication\Symfony\Form\CreateUserForm;
use Infrastructure\Authentication\Symfony\Form\UpdateUserForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Infrastructure\Shared\Symfony\Controller\DeleteCsrfTrait;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class UserController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/authentication/user', name: 'administration_authentication_user_')]
final class UserController extends AbstractController
{
    use DeleteCsrfTrait;

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(
        Request $request,
        UserRepository $repository,
        PaginatorInterface $paginator
    ): Response {
        return $this->render(
            view: '@admin/domain/authentication/user/index.html.twig',
            parameters: [
                'data' => $paginator->paginate(
                    target: $repository->findBy([], orderBy: [
                        'created_at' => 'DESC',
                    ]),
                    page: $request->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }

    #[Route('/{id<\d+>}', name: 'show', methods: ['GET'])]
    public function show(User $row): Response
    {
        return $this->render(
            view: '@admin/domain/authentication/user/show.html.twig',
            parameters: [
                'data' => $row,
            ]
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $command = new CreateUserCommand();
        $form = $this->createForm(CreateUserForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessfullActionFlash('création');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->renderForm(
            view: '@admin/domain/authentication/user/new.html.twig',
            parameters: [
                'form' => $form,
            ],
            response: $response ?? null
        );
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(User $row, Request $request): Response
    {
        $command = new UpdateUserCommand($row);
        $form = $this->createForm(UpdateUserForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessfullActionFlash('édition');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->renderForm(
            view: '@admin/domain/authentication/user/edit.html.twig',
            parameters: [
                'form' => $form,
                'data' => $row,
            ],
            response: $response ?? null
        );
    }

    #[Route('/ban/{id<\d+>}', name: 'ban', methods: ['POST'])]
    public function ban(User $row): Response
    {
        try {
            $this->dispatchSync(new BanUserCommand($row));
            $this->addSuccessfullActionFlash('bannissement');
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther('administration_authentication_user_show');
    }

    #[Route('/unban/{id<\d+}', name: 'unban', methods: ['POST'])]
    public function unban(User $row): Response
    {
        try {
            $this->dispatchSync(new UnbanUserCommand($row));
            $this->addSuccessfullActionFlash('annulation du bannissement');
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther('administration_authentication_user_show');
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(User $row, Request $request): Response
    {
        if ($this->isDeleteCsrfTokenValid($row, $request)) {
            try {
                $this->dispatchSync(new DeleteUserCommand($row));
                $this->addSuccessfullActionFlash('suppression');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }
        }

        return $this->redirectSeeOther('administration_authentication_user_index');
    }
}
