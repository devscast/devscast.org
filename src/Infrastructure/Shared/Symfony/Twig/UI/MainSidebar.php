<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig\UI;

use Infrastructure\Shared\Symfony\Twig\Sidebar\AbstractSidebar;
use Infrastructure\Shared\Symfony\Twig\Sidebar\SidebarBuilderInterface;
use Infrastructure\Shared\Symfony\Twig\Sidebar\SidebarCollection;
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
            ->addLink('administration_index', 'Dashboard', 'home')
            ->addHeader('Gestions des utilisateurs')
            ->addLink('administration_authentication_user_index', 'Utilisateurs', 'users')
            ->addHeader('Gestions du Contenus')
            ->addGroup('Blog', 'folder', [
                new SidebarLink('administration_content_post_index', 'Articles', 'folder'),
                new SidebarLink('administration_content_post_series_index', 'Séries', 'folder'),
                new SidebarLink('administration_content_post_list_index', 'Listes', 'folder'),
                new SidebarLink('administration_content_category_index', 'Catégories', 'folder'),
            ])
            ->addGroup('Podcast', 'folder', [
                new SidebarLink('administration_content_podcast_episode_index', 'Épisodes', 'folder'),
                new SidebarLink('administration_content_podcast_season_index', 'Saisons', 'folder'),
            ])
            ->addGroup('Formation', 'folder', [
                new SidebarLink('administration_content_video_index', 'Videos', 'folder'),
                new SidebarLink('administration_content_training_index', 'Formation', 'folder'),
                new SidebarLink('administration_content_training_chapter_index', 'Chapitres', 'folder'),
            ])
            ->addGroup('Autres', 'folder', [
                new SidebarLink('administration_content_technology_index', 'Technologies', 'folder'),
                new SidebarLink('administration_content_comment_index', 'Commentaires', 'folder'),
                new SidebarLink('administration_content_subject_proposal_index', 'Propositions Sujets', 'folder'),
                new SidebarLink('administration_content_tag_index', 'Tags', 'folder'),
            ])
            ->addHeader('Gestions des events')
        ;

        return $builder->create();
    }
}
