<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle;

use Devscast\Bundle\DddBundle\DependencyInjection\DevscastDddExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * class DevscastDddBundle.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class DevscastDddBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DevscastDddExtension();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
