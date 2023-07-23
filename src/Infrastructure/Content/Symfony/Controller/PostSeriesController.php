<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\PostSeries;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostSeriesController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/posts/series/', name: 'app_content_post_series_')]
final class PostSeriesController extends AbstractController
{
    #[Route(
        '',
        name: 'index',
        options: [
            'sitemap' => [
                'priority' => 0.6,
                'changefreg' => 'daily',
            ],
        ],
        methods: ['GET']
    )]
    public function index(): void
    {
    }

    #[Route(path: '/{slug<[a-zA-Z0-9-]+>}-{id<\d+>}', name: 'show', methods: ['GET'])]
    public function show(PostSeries $row, string $slug): void
    {
    }
}
