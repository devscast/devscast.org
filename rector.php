<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters
        ->set(Option::PATHS, [
            __DIR__ . '/src',
            __DIR__ . '/tests'
        ])
        ->set(
            Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER,
            __DIR__ . '/var/cache/dev/Infrastructure_Shared_Symfony_KernelDevDebugContainer.xml'
        );

    $containerConfigurator->import(Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_81);
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonySetList::SYMFONY_STRICT);
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonySetList::SYMFONY_60);
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonySetList::SYMFONY_CODE_QUALITY);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();
    $services->set(Rector\Symfony\Rector\MethodCall\SimplifyWebTestCaseAssertionsRector::class);
    $services->set(Rector\Symfony\Rector\New_\StringToArrayArgumentProcessRector::class);

    $services->set(Rector\Php74\Rector\Property\TypedPropertyRector::class);
    $services->set(Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
};
