<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Category;
use Domain\Content\Repository\CategoryRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

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
