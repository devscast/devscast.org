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
        $commandClassName = sprintf('%s', $input->getArgument('name'));
        $commandFormClassName = sprintf('%sForm', str_replace('Command', '', $commandClassName));
        $domain = $input->getArgument('domain');

        $this->createFile(
            template: 'command_form.php',
            params: [
                'commandClassProperties' => $this->getClassProperties("Application\\{$domain}\\Command\\{$commandClassName}"),
                'commandClassName' => $commandClassName,
                'commandFormClassName' => $commandFormClassName,
                'domain' => $domain,
            ],
            output: "src/Infrastructure/{$domain}/Symfony/Form/{$commandFormClassName}.php",
            force: false !== $input->getOption('force')
        );

        $this->io->text(sprintf('Form %s successfully created', $commandFormClassName));

        return Command::SUCCESS;
    }
}
