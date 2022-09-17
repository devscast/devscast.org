<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\DeleteUserCommand;
use Domain\Authentication\Event\UserDeletedEvent;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteUserHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->repository->delete($command->user);
        $this->dispatcher->dispatch(new UserDeletedEvent($command->user));
    }
}
