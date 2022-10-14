<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Admin;

use Application\Authentication\Command\BanUserCommand;
use Application\Authentication\Command\CreateUserCommand;
use Application\Authentication\Command\DeleteUserCommand;
use Application\Authentication\Command\EmailUserCommand;
use Application\Authentication\Command\UnbanUserCommand;
use Application\Authentication\Command\UpdateUserCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Doctrine\Repository\UserRepository;
use Infrastructure\Authentication\Symfony\Form\CreateUserForm;
use Infrastructure\Authentication\Symfony\Form\EmailUserForm;
use Infrastructure\Authentication\Symfony\Form\UpdateUserForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
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
final class UserController extends AbstractCrudController
{
    protected const DOMAIN = 'authentication';
    protected const ENTITY = 'user';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(UserRepository $repository): Response
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

    #[Route('/{id<\d+>}', name: 'show', methods: ['GET'])]
    public function show(User $row): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $row,
            ]
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $command = new CreateUserCommand();
        $form = $this->createForm(CreateUserForm::class, $command)
            ->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessfullActionFlash('création');

                return $this->redirectSeeOther($this->getRouteName('index'));
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = $this->createUnprocessableEntityResponse();
            }
        }

        return $this->renderForm(
            view: $this->getViewPath('new'),
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

                return $this->redirectSeeOther(
                    route: $this->getRouteName('show'),
                    params: [
                        'id' => $row->getId(),
                    ]
                );
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = $this->createUnprocessableEntityResponse();
            }
        }

        return $this->renderForm(
            view: $this->getViewPath('edit'),
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

        return $this->redirectSeeOther(
            route: $this->getRouteName('show'),
            params: [
                'id' => $row->getId(),
            ]
        );
    }

    #[Route('/unban/{id<\d+>}', name: 'unban', methods: ['POST'])]
    public function unban(User $row): Response
    {
        try {
            $this->dispatchSync(new UnbanUserCommand($row));
            $this->addSuccessfullActionFlash('annulation du bannissement');
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther(
            route: $this->getRouteName('show'),
            params: [
                'id' => $row->getId(),
            ]
        );
    }

    #[Route('/email/{id<\d+>}', name: 'email', methods: ['GET', 'POST'])]
    public function email(User $row, Request $request): Response
    {
        $command = new EmailUserCommand($row);
        $form = $this->createForm(EmailUserForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessfullActionFlash("envoie de l'email");

                return $this->redirectSeeOther(
                    route: $this->getRouteName('show'),
                    params: [
                        'id' => $row->getId(),
                    ]
                );
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = $this->createUnprocessableEntityResponse();
            }
        }

        return $this->renderForm(
            view: $this->getViewPath('email'),
            parameters: [
                'form' => $form,
                'data' => $row,
            ],
            response: $response ?? null
        );
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

        return $this->redirectSeeOther($this->getRouteName('index'));
    }
}
