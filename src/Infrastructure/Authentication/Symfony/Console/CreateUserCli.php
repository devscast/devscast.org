<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Console;

use Application\Authentication\Command\CreateBasicUserCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use function Symfony\Component\String\u;

/**
 * Class CreateUserCli.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsCommand(
    name: 'devscast:authentication:create-user',
    description: 'Creates users and stores them in the database',
)]
final class CreateUserCli extends Command
{
    private SymfonyStyle $io;

    public function __construct(
        private readonly MessageBusInterface $bus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates users and stores them in the database')
            ->addArgument('username', InputArgument::OPTIONAL, 'The username of the new user')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email of the new user')
            ->addArgument('password', InputArgument::OPTIONAL, 'The plain password of the new user')
            ->addOption('admin', null, InputOption::VALUE_NONE, 'If set, the user is created as an administrator');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (
            null !== $input->getArgument('username') &&
            null !== $input->getArgument('password') &&
            null !== $input->getArgument('email')
        ) {
            return;
        }

        $this->io->title('Add User Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console devscast:authentication:create-user name email@example.com password ',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        // Ask for the username if it's not defined
        /** @var string|null $username */
        $username = $input->getArgument('username');
        if ('' !== $username) {
            $this->io->text(' > <info>name</info>: ' . $username);
        } else {
            $username = $this->io->ask('username');
            $input->setArgument('username', $username);
        }

        // Ask for the password if it's not defined
        /** @var string|null $password */
        $password = $input->getArgument('password');
        if ('' !== $password) {
            $this->io->text(' > <info>Password</info>: ' . u('*')->repeat(u($password)->length())->toString());
        } else {
            $password = $this->io->askHidden('Password (your type will be hidden normally =D)');
            $input->setArgument('password', $password);
        }

        // Ask for the email if it's not defined
        /** @var string|null $email */
        $email = $input->getArgument('email');
        if ('' !== $email) {
            $this->io->text(' > <info>Email</info>: ' . $email);
        } else {
            $email = $this->io->ask('Email');
            $input->setArgument('email', $email);
        }
    }

    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('create-user-command');

        /** @var string $username */
        $username = $input->getArgument('username');

        /** @var string $password */
        $password = $input->getArgument('password');

        /** @var string $email */
        $email = $input->getArgument('email');

        /** @var bool|int|string $isAdmin */
        $isAdmin = $input->getOption('admin');
        $isAdmin = boolval($isAdmin);

        $this->bus->dispatch(new CreateBasicUserCommand($username, $email, $password));

        $this->io->success(sprintf('%s was successfully created: %s (%s)', $isAdmin ? 'Administrator user' : 'User', $username, $email));
        $event = $stopwatch->stop('create-user-command');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf(
                'New user database email: %s / Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                $email,
                $event->getDuration(),
                $event->getMemory() / (1024 ** 2)
            ));
        }

        return Command::SUCCESS;
    }
}
