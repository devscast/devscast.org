<?php

namespace Devscast\Bundle\DashliteBundle\DependencyInjection\Compiler;

use Devscast\Bundle\DashliteBundle\WhiteLabel;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * Class AddWhiteLabelTwigGlobalPass.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class AddWhiteLabelTwigGlobalPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->hasDefinition('twig')) {
            return;
        }

        $definition = $container->getDefinition('twig');
        $definition->addMethodCall('addGlobal', ['devscast_dashlite', new Reference('devscast_dashlite.whitelabel')]);
    }
}
