<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\EventListener;

use Application\Authentication\Command\RegenerateBackupCodeCommand;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Domain\Authentication\Entity\User;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class UserEmptyBackupCodeListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserEmptyBackupCodeListener
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {
    }

    public function postUpdate(User $user, LifecycleEventArgs $event): void
    {
        if (0 === \count($user->getBackupCode())) {
            $this->commandBus->dispatch(new RegenerateBackupCodeCommand($user));
            dump('event: listener !');
        }
    }
}
