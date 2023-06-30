<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Maker;

use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsCommand(
    name: 'ddd:make:domain',
    description: 'create a new domain',
)]
#[AsTaggedItem('console.command')]
class MakeDomainCli extends AbstractMakeCli
{
    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'The command class (e.g. <fg=yellow>Newsletter</>)');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askArgument($input, 'name');
    }

    /**
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $domain = Str::asCamelCase(strval($input->getArgument('name')));
        $lowerDomain = strtolower($domain);

        $this->createRawFile("config/domains/{$lowerDomain}.yaml", false);
        $this->createRawFile("translations/{$lowerDomain}.fr.yaml", false);
        $this->createRawFile("templates/app/domain/{$lowerDomain}/.gitignore");
        $this->createRawFile("templates/admin/domain/{$lowerDomain}/.gitignore");
        $this->createRawFile("fixtures/data/{$lowerDomain}/fixtures.yaml", false);
        $this->createRawFile("fixtures/data/{$lowerDomain}/templates.yaml", false);

        // domain
        $this->createRawFile("src/Domain/{$domain}/Entity/.gitignore");
        $this->createRawFile("src/Domain/{$domain}/Event/.gitignore");
        $this->createRawFile("src/Domain/{$domain}/Exception/.gitignore");
        $this->createRawFile("src/Domain/{$domain}/Repository/.gitignore");
        $this->createRawFile("src/Domain/{$domain}/ValueObject/.gitignore");

        // application
        $this->createRawFile("src/Application/{$domain}/Command/.gitignore");
        $this->createRawFile("src/Application/{$domain}/Handler/.gitignore");
        $this->createRawFile("src/Application/{$domain}/Service/.gitignore");

        // infrastructure
        $this->createRawFile("src/Infrastructure/{$domain}/Doctrine/Repository/.gitignore");
        $this->createRawFile("src/Infrastructure/{$domain}/Doctrine/Mapping/Entity/.gitignore");
        $this->createRawFile("src/Infrastructure/{$domain}/Doctrine/Mapping/ValueObject/.gitignore");
        $this->createRawFile("src/Infrastructure/{$domain}/Symfony/Controller/.gitignore");
        $this->createRawFile("src/Infrastructure/{$domain}/Symfony/Form/.gitignore");

        $this->io->text(sprintf('Domain %s successfully created', $domain));

        return Command::SUCCESS;
    }
}
