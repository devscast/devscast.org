<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\BanUserCommand;
use Domain\Authentication\Event\UserBannedEvent;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class BanUserHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class BanUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(BanUserCommand $command): void
    {
        $this->repository->save(
            $command->user
                ->setIsBanned(true)
                ->setBannedAt(new \DateTimeImmutable())
        );
        $this->dispatcher->dispatch(new UserBannedEvent($command->user));
    }
}
