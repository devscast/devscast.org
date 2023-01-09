<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Entity\Post;
use Domain\Content\Repository\ContentRepositoryInterface;
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
    #[Route('/{content_type<podcasts|posts>}/feed.rss', name: 'content_feed', methods: ['GET'], priority: 20)]
    public function __invoke(ContentRepositoryInterface $repository, string $content_type): Response
    {
        /** @var PodcastEpisode[]|Post[] $data */
        $data = match ($content_type) {
            'podcasts' => $repository->findContents(PodcastEpisode::class),
            default => $repository->findLatestContents(Post::class, 10)
        };

        $response = $this->render(
            view: match ($content_type) {
                'podcasts' => '@app/domain/content/podcast_episode/feed.xml.twig',
                default => '@app/domain/content/post/feed.xml.twig'
            },
            parameters: [
                'data' => $data,
            ]
        );
        $response->headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        return $response;
    }
}
