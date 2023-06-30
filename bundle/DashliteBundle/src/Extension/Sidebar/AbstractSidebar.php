<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Extension\Sidebar;

/**
 * Class AbstractSidebar.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractSidebar
{
    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    abstract public function build(SidebarBuilderInterface $builder): SidebarCollection;
}
