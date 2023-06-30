<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Admin;

use Application\Authentication\Command\BanUserCommand;
use Application\Authentication\Command\CreateUserCommand;
use Application\Authentication\Command\DeleteUserCommand;
use Application\Authentication\Command\EmailUserCommand;
use Application\Authentication\Command\UnbanUserCommand;
use Application\Authentication\Command\UpdateUserCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Doctrine\Repository\UserRepository;
use Infrastructure\Authentication\Symfony\Form\CreateUserForm;
use Infrastructure\Authentication\Symfony\Form\EmailUserForm;
use Infrastructure\Authentication\Symfony\Form\UpdateUserForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class UserController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/authentication/user', name: 'admin_authentication_user_')]
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
    public function show(User $item): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $item,
            ]
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreateUserCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateUserForm::class,
        ));
    }

    #[Route('/edit/{id}', name: 'edit', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET', 'POST'])]
    public function edit(User $item, Request $request): Response
    {
        return $this->handleCommand(new UpdateUserCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateUserForm::class
        ));
    }

    #[Route('/ban/{id}', name: 'ban', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST'])]
    public function ban(User $item): Response
    {
        return $this->handleCommand(new BanUserCommand($item), new CrudParams(item: $item));
    }

    #[Route('/unban/{id}', name: 'unban', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST'])]
    public function unban(User $item): Response
    {
        return $this->handleCommand(new UnbanUserCommand($item), new CrudParams(item: $item));
    }

    #[Route('/email/{id}', name: 'email', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET', 'POST'])]
    public function email(User $item, Request $request): Response
    {
        return $this->handleCommand(new EmailUserCommand($item), new CrudParams(
            item: $item,
            formClass: EmailUserForm::class,
            view: 'email'
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(User $item): Response
    {
        return $this->handleCommand(new DeleteUserCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
