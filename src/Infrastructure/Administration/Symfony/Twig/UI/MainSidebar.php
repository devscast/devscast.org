<?php

declare(strict_types=1);

namespace Infrastructure\Administration\Symfony\Twig\UI;

use Infrastructure\Administration\Symfony\Twig\Sidebar\AbstractSidebar;
use Infrastructure\Administration\Symfony\Twig\Sidebar\SidebarBuilderInterface;
use Infrastructure\Administration\Symfony\Twig\Sidebar\SidebarCollection;
use Infrastructure\Administration\Symfony\Twig\Sidebar\Type\SidebarHeader;
use Infrastructure\Administration\Symfony\Twig\Sidebar\Type\SidebarLink;

/**
 * class MainSidebar.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MainSidebar extends AbstractSidebar
{
    public function build(SidebarBuilderInterface $builder): SidebarCollection
    {
        $builder
            ->add(new SidebarHeader('Authentication'))
            ->add(new SidebarLink('administration_authentication_user_index', 'users', 'users'));

        return $builder->create();
    }
}
