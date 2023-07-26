<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Maker;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsCommand(
    name: 'ddd:make:command',
    description: 'Create a new command class',
)]
#[AsTaggedItem('console.command')]
class MakeCommandCli extends AbstractMakeCli
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the command class (e.g. <fg=yellow>SendNewsletterCommand</>)')
            ->addArgument('domain', InputArgument::OPTIONAL, 'The domain of the command class (e.g. <fg=yellow>Mailing</>)')
            ->addArgument('entity', InputArgument::OPTIONAL, 'The entity class (e.g. <fg=yellow>Newsletter</>)')
            ->addOption('with-handler', null, InputOption::VALUE_OPTIONAL, 'The handler class (e.g. <fg=yellow>SendNewsletterHandler</>)', false)
            ->addOption('with-form', null, InputOption::VALUE_OPTIONAL, 'The form class (e.g. <fg=yellow>SendNewsletterForm</>)', false);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askDomain($input);
        $this->askClass($input, 'entity', "Domain/{$input->getArgument('domain')}/Entity/*");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getArgument('name') === null) {
            $entities = $this->findFiles(
                path: sprintf("src/Domain/%s/Entity", $input->getArgument('domain')),
                suffix: '.php'
            );

            $this->io->text(sprintf('Found %d entities in domain %s', count($entities), $input->getArgument('domain')));
            $confirm = $this->io->confirm('Do you want to create commands for all entities?', false);

            if ($confirm) {
                foreach ($entities as $entity) {
                    foreach (['Create', 'Update', 'Delete'] as $command) {
                        $this->createCommand(
                            name: sprintf("%s%s", $command, $entity),
                            entity: $entity,
                            domain: $input->getArgument('domain'),
                            force: $input->getOption('force') !== false
                        );
                    }
                }
            }
        } else {
            $this->createCommand(
                name: $input->getArgument('name'),
                entity: $input->getArgument('entity'),
                domain: $input->getArgument('domain'),
                force: $input->getOption('force') !== false
            );

            try {
                if (false !== $input->getOption('with-handler')) {
                    $makeHandlerCli = $this->getApplication()?->find('ddd:make:handler');
                    $makeHandlerCli?->run(new ArrayInput([
                        'name' => (string) $input->getArgument('name'),
                        'domain' => $input->getArgument('domain'),
                        'entity' => $input->getArgument('entity'),
                    ]), $output);
                }

                if (false !== $input->getOption('with-form')) {
                    $makeFormCli = $this->getApplication()?->find('ddd:make:form');
                    $makeFormCli?->run(new ArrayInput([
                        'name' => (string) $input->getArgument('name'),
                        'domain' => $input->getArgument('domain'),
                    ]), $output);
                }
            } catch(\Throwable $e) {
                $this->io->error($e->getMessage());
                return Command::FAILURE;
            }
        }


        return Command::SUCCESS;
    }

    private function createCommand(string $name, string $entity, string $domain, bool $force): void
    {
        $commandClassName = sprintf('%sCommand', $name);
        $entityClassName = $entity;

        $this->createFile(
            template: 'command.php',
            params: [
                'commandClassName' => $commandClassName,
                'entityClassName' => '' === $entityClassName ? false : $entityClassName,
                'entityClassProperties' => $this->getClassProperties(
                    fqcn: "Domain\\{$domain}\\Entity\\{$entityClassName}",
                    ignore: ['id']
                ),
                'domain' => $domain,
                'is_update_command' => str_starts_with($commandClassName, 'Update'),
                'is_delete_command' => str_starts_with($commandClassName, 'Delete'),
                'is_create_command' => str_starts_with($commandClassName, 'Create'),
            ],
            output: "src/Application/{$domain}/Command/{$commandClassName}.php",
            force: false !== $force
        );
        $this->io->text(sprintf('Command %s successfully created', $commandClassName));
    }
}
