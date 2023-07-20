<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle;

use Devscast\Bundle\DashliteBundle\DependencyInjection\Compiler\AddWhiteLabelTwigGlobalPass;
use Devscast\Bundle\DashliteBundle\DependencyInjection\DevscastDashliteExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * class DevscastDashliteBundle.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class DevscastDashliteBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new AddWhiteLabelTwigGlobalPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DevscastDashliteExtension();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
