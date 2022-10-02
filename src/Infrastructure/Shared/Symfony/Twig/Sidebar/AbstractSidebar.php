<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\Sidebar;

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
