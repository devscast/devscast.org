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
    name: 'ddd:make:exception',
    description: 'Create a new exception class',
)]
#[AsTaggedItem('console.command')]
class MakeExceptionCli extends AbstractMakeCli
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the command class (e.g. <fg=yellow>SendNewsletterCommand</>)')
            ->addArgument('domain', InputArgument::OPTIONAL, 'The domain of the command class (e.g. <fg=yellow>Mailing</>)');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askArgument($input, 'name');
        $this->askDomain($input);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $domain = $input->getArgument('domain');
        $exceptionClassName = sprintf('%sException', $input->getArgument('name'));
        $exceptionMessage = Str::asSnakeCase(str_ireplace('Exception', '', $exceptionClassName));

        $this->createFile(
            template: 'exception.php',
            params: [
                'exceptionClassName' => $exceptionClassName,
                'exceptionMessage' => $exceptionMessage,
                'domain' => $domain,
            ],
            output: "src/Domain/{$domain}/Exception/{$exceptionClassName}.php",
            force: false !== $input->getOption('force')
        );
        $this->io->text(sprintf('Exception %s successfully created', $exceptionClassName));

        return Command::SUCCESS;
    }
}
