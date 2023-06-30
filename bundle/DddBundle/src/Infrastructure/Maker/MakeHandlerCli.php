<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Maker;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsCommand(
    name: 'ddd:make:handler',
    description: 'Create a new command handler class',
)]
#[AsTaggedItem('console.command')]
class MakeHandlerCli extends AbstractMakeCli
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the command class (e.g. <fg=yellow>SendNewsletterCommand</>)')
            ->addArgument('domain', InputArgument::OPTIONAL, 'The domain of the command class (e.g. <fg=yellow>Mailing</>)')
            ->addArgument('entity', InputArgument::OPTIONAL, 'The entity class (e.g. <fg=yellow>Newsletter</>)');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askDomain($input);
        $this->askArgument($input, 'entity');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commandClassName = sprintf('%sCommand', $input->getArgument('name'));
        $handlerClassName = sprintf('%sHandler', $input->getArgument('name'));
        $repositoryInterfaceName = sprintf('%sRepositoryInterface', $input->getArgument('entity'));
        $entityClassName = sprintf('%s', $input->getArgument('entity'));
        $domain = $input->getArgument('domain');

        $this->createFile(
            template: 'handler.php',
            params: [
                'commandClassName' => $commandClassName,
                'handlerClassName' => $handlerClassName,
                'entityClassName' => '' === $entityClassName ? false : $entityClassName,
                'repositoryInterfaceName' => 'RepositoryInterface' === $repositoryInterfaceName ? false : $repositoryInterfaceName,
                'domain' => $domain,
                'is_create_command' => str_starts_with($commandClassName, 'Create'),
                'is_update_command' => str_starts_with($commandClassName, 'Update'),
                'is_delete_command' => str_starts_with($commandClassName, 'Delete'),
            ],
            output: "src/Application/{$domain}/Handler/{$handlerClassName}.php",
            force: false !== $input->getOption('force')
        );
        $this->io->text(sprintf('Handler %s successfully created', $handlerClassName));

        return Command::SUCCESS;
    }
}
