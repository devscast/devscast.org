<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\Post;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/posts', name: 'app_content_post_')]
final class PostController extends AbstractController
{
    #[Route('/preview/{id}', name: 'preview', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'], priority: 15)]
    public function preview(Post $row): void
    {
    }
}
