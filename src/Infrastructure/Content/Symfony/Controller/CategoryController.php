<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\Category;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/content/category', name: 'app_content_category_')]
final class CategoryController extends AbstractController
{
    #[Route('/{slug<[a-zA-Z0-9-]+>}', name: 'show', methods: ['GET'])]
    public function __invoke(Category $item): void
    {
    }
}
