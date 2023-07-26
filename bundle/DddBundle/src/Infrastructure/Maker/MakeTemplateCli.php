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
    name: 'ddd:make:template',
    description: 'Create a new admin template',
)]
#[AsTaggedItem('console.command')]
class MakeTemplateCli extends AbstractMakeCli
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the template')
            ->addArgument('domain', InputArgument::OPTIONAL, 'The domain of the crud')
            ->addArgument('entity', InputArgument::OPTIONAL, 'The entity of the crud');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askArgument($input, 'name');
        $this->askDomain($input);
        $this->askClass($input, 'entity', "Domain/{$input->getArgument('domain')}/Entity/*");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $domain = (string) $input->getArgument('domain');

        if ($input->getArgument('entity') === null) {
            $entities = $this->findFiles(
                path: "{$this->projectDir}/src/Domain/{$domain}/Entity",
                suffix: '.php'
            );

            $this->io->text(sprintf('Found %d entities in domain %s', count($entities), $domain));
            $confirm = $this->io->confirm('Do you want to create templates for all entities ?', false);

            if ($confirm && count($entities) > 0) {
                foreach ($entities as $entity) {
                    foreach (['index', 'show'] as $name) {
                        $this->createTemplate(
                            name: $name,
                            domain: $domain,
                            entity: $entity,
                            force: $input->getOption('force') !== false
                        );
                    }
                }
            }
        } else {
            $this->createTemplate(
                name: $input->getArgument('name'),
                domain: $domain,
                entity: (string) $input->getArgument('entity'),
                force: $input->getOption('force') !== false
            );
        }

        return Command::SUCCESS;
    }

    private function createTemplate(string $name, string $domain, string $entity, bool $force): void
    {
        $name = Str::asTwigVariable($name);
        $domain = Str::asTwigVariable($domain);
        $entity = Str::asTwigVariable($entity);

        $this->createFile(
            template: "template_{$name}.twig",
            params: [
                'domain' => $domain,
                'entity' => Str::asTwigVariable($entity),
                'entityClassProperties' => $this->getClassProperties(sprintf("Domain\\%s\\Entity\\%s", Str::asCamelCase($domain), Str::asClassName($entity)))
            ],
            output: "templates/admin/domain/{$domain}/{$entity}/{$name}.html.twig",
            force: $force
        );

        $this->io->text(sprintf('Created template %s', "templates/admin/domain/{$domain}/{$entity}/{$name}.html.twig"));
    }
}
