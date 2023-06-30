<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Content\Entity\Category;
use Domain\Content\Entity\PostSeries;

/**
 * Interface PostRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface PostRepositoryInterface extends DataRepositoryInterface
{
    public function findBySeries(PostSeries $series): array;

    public function findByCategory(Category $category): array;
}
