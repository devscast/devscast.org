<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ExportBackupCodeCommand;
use Application\Authentication\Command\GenerateBackupCodeCommand;
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
        private readonly MessageBusInterface $bus
    ) {
    }

    public function __invoke(ExportBackupCodeCommand $command): string
    {
        $user = $command->user;
        if (0 === count($user->getBackupCodes())) {
            $this->bus->dispatch(new GenerateBackupCodeCommand($user));
        }

        return implode("\n", $user->getBackupCodes());
    }
}
