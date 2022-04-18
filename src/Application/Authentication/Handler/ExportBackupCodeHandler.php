<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ExportBackupCodeCommand;
use Application\Authentication\Command\RegenerateBackupCodeCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class ExportBackupCodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ExportBackupCodeHandler
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {
    }

    public function __invoke(ExportBackupCodeCommand $command): string
    {
        $user = $command->user;
        if (0 === count($user->getBackupCode())) {
            $this->commandBus->dispatch(new RegenerateBackupCodeCommand($user));
        }

        return implode("\n", $user->getBackupCode());
    }
}
