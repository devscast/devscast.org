<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Entity\Post;
use Domain\Content\Repository\PostRepositoryInterface;
use Infrastructure\Content\Doctrine\Repository\PodcastEpisodeRepository;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class RssFeedController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class RssFeedController extends AbstractController
{
    #[Route('/podcasts/feed.rss', name: 'content_podcast_episode_feed', methods: ['GET'], priority: 20)]
    public function podcasts(PodcastEpisodeRepository $repository): Response
    {
        /** @var PodcastEpisode[] $data */
        $data = $repository->findAll();
        $response = $this->render(
            view: '@app/domain/content/podcast_episode/feed.xml.twig',
            parameters: [
                'data' => $data,
            ]
        );
        $response->headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        return $response;
    }

    #[Route('/posts/feed.rss', name: 'content_post_feed', methods: ['GET'], priority: 20)]
    public function posts(PostRepositoryInterface $repository): Response
    {
        /** @var Post[] $data */
        $data = $repository->findBy([], limit: 10);
        $response = $this->render(
            view: '@app/domain/content/post/feed.xml.twig',
            parameters: [
                'data' => $data,
            ]
        );
        $response->headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        return $response;
    }
}
