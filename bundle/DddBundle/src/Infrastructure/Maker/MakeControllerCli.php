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
    name: 'ddd:make:controller',
    description: 'Create a new crud controller class',
)]
#[AsTaggedItem('console.command')]
class MakeControllerCli extends AbstractMakeCli
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->addArgument('domain', InputArgument::OPTIONAL, 'The domain of the command class (e.g. <fg=yellow>Mailing</>)')
            ->addArgument('entity', InputArgument::OPTIONAL, 'The entity class (e.g. <fg=yellow>Newsletter</>)');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askDomain($input);
        $this->askClass($input, 'entity', "Domain/{$input->getArgument('domain')}/Entity/*");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityClassName = (string) $input->getArgument('entity');
        $domain = (string) $input->getArgument('domain');

        $this->createFile(
            template: 'controller_crud.php',
            params: [
                'entityClassName' => '' === $entityClassName ? false : $entityClassName,
                'domain' => $domain,
            ],
            output: "src/Infrastructure/{$domain}/Symfony/Controller/Admin/{$entityClassName}Controller.php",
            force: false !== $input->getOption('force')
        );
        $this->io->text(sprintf('%sController successfully created', $entityClassName));

        return Command::SUCCESS;
    }
}
