<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * class DevscastDashliteExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DevscastDashliteExtension extends Extension
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('components.xml');
        $loader->load('extensions.xml');
    }

    public function getAlias(): string
    {
        return 'devscast_dashlite';
    }
}
