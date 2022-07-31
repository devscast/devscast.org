<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\EventListener;

use Application\Authentication\Command\GenerateBackupCodeCommand;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Domain\Authentication\Entity\User;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class GenerateBackupCodeListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GenerateBackupCodeListener
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {
    }

    public function postUpdate(User $user, LifecycleEventArgs $event): void
    {
        if ($user->isEmptyBackupCodes()) {
            $this->commandBus->dispatch(new GenerateBackupCodeCommand($user));
        }
    }
}
