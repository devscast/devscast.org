<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Command;

use Application\Authentication\Command\CleanResetPasswordTokenCommand as CleanRepositoryCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * class CleanResetPasswordTokenCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsCommand(
    name: 'devscast:authentication:clean-reset-password-token',
    description: 'clean reset password tokens'
)]
final class CleanResetPasswordTokenCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(new CleanRepositoryCommand());

        return Command::SUCCESS;
    }
}
