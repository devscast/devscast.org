<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository\Blog;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Blog\Category;
use Domain\Content\Repository\Blog\CategoryRepositoryInterface;

/**
 * class CategoryRepository.
 *
 * @extends AbstractRepository<Category>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
}
