<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Symplify\EasyCodingStandard\ValueObject\Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $containerConfigurator->import(Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12);
    $containerConfigurator->import(Symplify\EasyCodingStandard\ValueObject\Set\SetList::COMMON);
    $containerConfigurator->import(Symplify\EasyCodingStandard\ValueObject\Set\SetList::CLEAN_CODE);
    $containerConfigurator->import(Symplify\EasyCodingStandard\ValueObject\Set\SetList::SYMFONY);

    $services = $containerConfigurator->services();
    $services->remove(PhpCsFixer\Fixer\Operator\ConcatSpaceFixer::class);
};
