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
        return $this->queryIndex($repository);
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
        return $this->executeFormCommand(
            command: new CreateUserCommand(),
            formClass: CreateUserForm::class,
        );
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(User $row, Request $request): Response
    {
        return $this->executeFormCommand(
            command: new UpdateUserCommand($row),
            formClass: UpdateUserForm::class,
            row: $row,
            view: 'edit',
            overrideFormViews: true
        );
    }

    #[Route('/ban/{id<\d+>}', name: 'ban', methods: ['POST'])]
    public function ban(User $row): Response
    {
        return $this->executeCommand(new BanUserCommand($row), $row);
    }

    #[Route('/unban/{id<\d+>}', name: 'unban', methods: ['POST'])]
    public function unban(User $row): Response
    {
        return $this->executeCommand(new UnbanUserCommand($row), $row);
    }

    #[Route('/email/{id<\d+>}', name: 'email', methods: ['GET', 'POST'])]
    public function email(User $row, Request $request): Response
    {
        return $this->executeFormCommand(
            command: new EmailUserCommand($row),
            formClass: EmailUserForm::class,
            row: $row,
            view: 'email'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(User $row): Response
    {
        return $this->executeDeleteCommand(new DeleteUserCommand($row), $row);
    }
}
