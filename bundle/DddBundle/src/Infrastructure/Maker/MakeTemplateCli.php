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
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the template')
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
        $name = Str::asTwigVariable($input->getArgument('name'));
        $domain = Str::asTwigVariable($input->getArgument('domain'));
        $entity = Str::asTwigVariable($input->getArgument('entity'));

        $this->createFile(
            template: "template_{$name}.twig",
            params: [
                'domain' => $domain,
                'entity' => Str::asTwigVariable($entity)
            ],
            output: "templates/admin/domain/{$domain}/{$entity}/{$name}.html.twig",
            force: false !== $input->getOption('force')
        );
        $this->io->text('templates : index.twig successfully created');

        return Command::SUCCESS;
    }
}
