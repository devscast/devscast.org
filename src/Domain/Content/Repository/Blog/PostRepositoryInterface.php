<?php

declare(strict_types=1);

namespace Domain\Content\Repository\Blog;

use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Content\Entity\Blog\Category;

/**
 * Interface PostRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface PostRepositoryInterface extends DataRepositoryInterface
{
    public function findByCategory(Category $category): array;
}
