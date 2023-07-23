<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\PostList;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/posts/lists', name: 'app_content_post_')]
final class PostListController extends AbstractController
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
    public function show(PostList $row, string $slug): void
    {
        $this->denyAccessUnlessGranted('CONTENT_POST_LIST_SHOW', $row);
    }
}
