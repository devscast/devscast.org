<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ExportBackupCodeCommand;
use Application\Authentication\Command\RegenerateBackupCodeCommand;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class ExportBackupCodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ExportBackupCodeHandler implements MessageHandlerInterface
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
