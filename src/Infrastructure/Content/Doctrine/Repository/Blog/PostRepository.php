<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository\Blog;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Blog\Category;
use Domain\Content\Entity\Blog\Post;
use Domain\Content\Repository\Blog\PostRepositoryInterface;

/**
 * class PostRepository.
 *
 * @extends AbstractRepository<Post>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PostRepository extends AbstractRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findByCategory(Category $category): array
    {
        return $this->findBy([
            'category' => $category,
        ], [
            'created_at' => 'DESC',
        ]);
    }
}
