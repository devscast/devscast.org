<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Extension\Sidebar\Type;

/**
 * Interface SidebarItemInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface SidebarItemInterface
{
    public function getLabel(): string;
}
