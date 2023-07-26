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
    name: 'ddd:make:form',
    description: 'create a new form class',
)]
#[AsTaggedItem('console.command')]
class MakeFormCli extends AbstractMakeCli
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'The command class (e.g. <fg=yellow>Newsletter</>)')
            ->addArgument('domain', InputArgument::OPTIONAL, 'The domain of the command class (e.g. <fg=yellow>Mailing</>)');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askDomain($input);
        $this->askClass($input, 'name', "Application/{$input->getArgument('domain')}/Command/*");
    }

    /**
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getArgument('name') === null) {
            $commands = $this->findFiles(
                path: sprintf("src/Application/%s/Command", $input->getArgument('domain')),
                suffix: '.php'
            );

            $this->io->text(sprintf('Found %d commands in domain %s', count($commands), $input->getArgument('domain')));
            $confirm = $this->io->confirm('Do you want to create forms for all commands?', false);

            if ($confirm) {
                foreach ($commands as $command) {
                    if (!str_starts_with('Delete', $command)) {
                        $this->createForm(
                            name: $command,
                            domain: $input->getArgument('domain'),
                            force: $input->getOption('force') !== false
                        );
                    }
                }
            }
        } else {
            $this->createForm(
                name: $input->getArgument('name'),
                domain: $input->getArgument('domain'),
                force: $input->getOption('force') !== false
            );
        }

        return Command::SUCCESS;
    }

    private function createForm(string $name, string $domain, bool $force): void
    {
        $commandClassName = sprintf('%s', $name);
        $commandFormClassName = sprintf('%sForm', str_replace('Command', '', $commandClassName));

        $this->createFile(
            template: 'command_form.php',
            params: [
                'commandClassProperties' => $this->getClassProperties(
                    fqcn: "Application\\{$domain}\\Command\\{$commandClassName}"
                ),
                'commandClassName' => $commandClassName,
                'commandFormClassName' => $commandFormClassName,
                'domain' => $domain,
            ],
            output: "src/Infrastructure/{$domain}/Symfony/Form/{$commandFormClassName}.php",
            force: false !== $force
        );

        $this->io->text(sprintf('Form %s successfully created', $commandFormClassName));
    }
}
