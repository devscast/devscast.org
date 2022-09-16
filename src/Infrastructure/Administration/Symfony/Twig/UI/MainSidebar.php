<?php

declare(strict_types=1);

namespace Infrastructure\Administration\Symfony\Twig\UI;

use Infrastructure\Administration\Symfony\Twig\Sidebar\AbstractSidebar;
use Infrastructure\Administration\Symfony\Twig\Sidebar\SidebarBuilderInterface;
use Infrastructure\Administration\Symfony\Twig\Sidebar\SidebarCollection;

/**
 * class MainSidebar.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MainSidebar extends AbstractSidebar
{
    public function build(SidebarBuilderInterface $builder): SidebarCollection
    {
        return $builder->create();
    }
}
