<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\UI;

use Infrastructure\Shared\Symfony\Twig\Sidebar\AbstractSidebar;
use Infrastructure\Shared\Symfony\Twig\Sidebar\SidebarBuilderInterface;
use Infrastructure\Shared\Symfony\Twig\Sidebar\SidebarCollection;
use Infrastructure\Shared\Symfony\Twig\Sidebar\Type\SidebarHeader;
use Infrastructure\Shared\Symfony\Twig\Sidebar\Type\SidebarLink;

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
            ->add(new SidebarLink('administration_authentication_user_index', 'users', 'users'))
            ->add(new SidebarHeader('Content'))
            ->add(new SidebarLink('administration_content_subject_proposal_index', 'subject proposals', 'cc-new'))
            ->add(new SidebarLink('administration_content_post_index', 'posts', 'book-read'))
            ->add(new SidebarLink('administration_content_podcast_episode_index', 'podcasts episodes', 'mic'))
            ->add(new SidebarLink('administration_content_podcast_season_index', 'podcast seasons', 'mic'))
            ->add(new SidebarLink('administration_content_video_index', 'videos', 'video'))
            ->add(new SidebarHeader('Settings'))
        ;

        return $builder->create();
    }
}
