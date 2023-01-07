<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\Entity\Post;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/posts', name: 'content_post_')]
final class PostController extends AbstractController
{
    #[Route('/preview/{uuid<[a-zA-Z0-9-]+>}', name: 'preview', methods: ['GET'], priority: 15)]
    public function preview(Post $row): void
    {
    }
}
