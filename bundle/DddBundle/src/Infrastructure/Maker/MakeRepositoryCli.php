<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Maker;

use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsCommand(
    name: 'ddd:make:repository',
    description: 'create a new repository class',
)]
#[AsTaggedItem('console.command')]
class MakeRepositoryCli extends AbstractMakeCli
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
        $this->askArgument($input, 'entity');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $domain = is_string($input->getArgument('domain')) ? $input->getArgument('domain') : null;
        if ($input->getArgument('entity') == null) {
            $entities = $this->findFiles(
                path: "{$this->projectDir}/src/Domain/{$domain}/Entity",
                suffix: '.php'
            );

            $this->io->text(sprintf('Found %d entities in domain %s', count($entities), $input->getArgument('domain')));
            $confirm = $this->io->confirm('Do you want to create repositories for all entities?', false);

            foreach ($entities as $entity) {
                $makeRepositoryCli = $this->getApplication()?->find('ddd:make:repository');
                $makeRepositoryCli?->run(new ArrayInput([
                    'domain' => $domain,
                    'entity' => $entity,
                    '--force' => $input->getOption('force')
                ]), $output);
            }
        }

        $repositoryInterfaceName = sprintf('%sRepositoryInterface', $input->getArgument('entity'));
        $repositoryClassName = sprintf('%sRepository', $input->getArgument('entity'));
        $entityClassName = sprintf('%s', $input->getArgument('entity'));

        if ($entityClassName !== "") {
            $this->createFile(
                template: 'repository_interface.php',
                params: [
                    'entityClassName' => '' == $entityClassName ? false : $entityClassName,
                    'repositoryInterfaceName' => 'RepositoryInterface' === $repositoryInterfaceName ? false : $repositoryInterfaceName,
                    'domain' => $domain,
                ],
                output: "src/Domain/{$domain}/Repository/{$repositoryInterfaceName}.php",
                force: false !== $input->getOption('force')
            );

            $this->createFile(
                template: 'repository.php',
                params: [
                    'entityClassName' => '' == $entityClassName ? false : $entityClassName,
                    'repositoryInterfaceName' => 'RepositoryInterface' === $repositoryInterfaceName ? false : $repositoryInterfaceName,
                    'repositoryClassName' => $repositoryClassName,
                    'domain' => $domain,
                ],
                output: "src/Infrastructure/{$domain}/Doctrine/Repository/{$repositoryClassName}.php",
                force: false !== $input->getOption('force')
            );

            $this->io->text(sprintf('RepositoryInterface %s successfully created', $repositoryInterfaceName));
            $this->io->text(sprintf('Repository %s successfully created', $repositoryClassName));
        }

        return Command::SUCCESS;
    }
}
