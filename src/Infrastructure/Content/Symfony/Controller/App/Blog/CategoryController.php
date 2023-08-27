<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\App\Blog;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\Blog\Category;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/posts/category', name: 'app_content_blog_category_')]
final class CategoryController extends AbstractController
{
    #[Route('/{slug<[a-zA-Z0-9-]+>}', name: 'show', methods: ['GET'])]
    public function __invoke(Category $item): void
    {
    }
}
