<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Category;
use Domain\Content\Entity\Post;
use Domain\Content\Entity\PostSeries;
use Domain\Content\Repository\PostRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

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

    public function findBySeries(PostSeries $series): array
    {
        return $this->findBy([
            'series' => $series,
        ], [
            'created_at' => 'DESC',
        ]);
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
