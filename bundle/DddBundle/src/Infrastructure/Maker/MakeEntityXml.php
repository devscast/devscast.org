<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Maker;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\MappingException;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Twig\Environment;

/**
 * Class MakeEntityXml.
 *
 * @template-covariant T of object
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsCommand(
    name: 'ddd:make:entity-xml',
    description: 'create entities from doctrine xml mapping',
)]
#[AsTaggedItem('console.command')]
class MakeEntityXml extends AbstractMakeCli
{
    public function __construct(Environment $twig, string $projectDir, private readonly SimplifiedXmlDriver $driver)
    {
        parent::__construct($twig, $projectDir);
    }

    protected function configure(): void
    {
        parent::configure();
        $this
            ->addArgument('domain', InputArgument::OPTIONAL, 'The domain of the command class (e.g. <fg=yellow>Mailing</>)')
            ->addArgument('entity', InputArgument::OPTIONAL, 'The entity class name (e.g. <fg=yellow>WatchHistory</>)')
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->askDomain($input);
        $this->askArgument($input, 'entity');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws MappingException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $domain = is_string($input->getArgument('domain')) ? strval($input->getArgument('domain')) : null;
        $this->addTwigFunction('ucfirst', fn (string $s) => ucfirst($s));
        $this->addTwigFunction('getType', function (string $type) {
            return match ($type) {
                "dateinterval" => "\DateInterval",
                "datetime" => "\DateTime",
                "datetime_immutable", "date" => "\DateTimeImmutable",
                "json" => "array",
                "boolean" => "bool",
                "float" => "float",
                "integer", 'bigint', 'smallint' => "int",
                "string", "text" => "string",
            };
        });

        foreach ($this->driver->getAllClassNames() as $className) {

            $entity = $input->getArgument('entity');
            $filter = $entity !== null ?
                "Domain\\{$domain}\\Entity\\{$entity}" :
                "Domain\\{$domain}\\Entity\\";

            /** @var class-string<T> $className */
            if (str_contains($className, $filter)) {

                /** @var ClassMetadata<T> $info */
                $info = new ClassMetadataInfo($className);
                $this->driver->loadMetadataForClass($className, $info);

                $entityClassName = Str::getShortClassName($info->name);
                $this->createFile(
                    template: 'entity.php',
                    params: [
                        'entityClassName' => $entityClassName,
                        'info' => $info,
                        'domain' => $domain
                    ],
                    output: "src/Domain/{$domain}/Entity/{$entityClassName}.php",
                    force: false !== $input->getOption('force')
                );
                $this->io->text(sprintf("Entity %s successfully created", $entityClassName));
            }
        }

        return Command::SUCCESS;
    }
}
