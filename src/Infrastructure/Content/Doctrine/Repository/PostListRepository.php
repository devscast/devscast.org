<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\PostList;
use Domain\Content\Repository\PostListRepositoryInterface;

/**
 * class PostListRepository.
 *
 * @extends AbstractRepository<PostList>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PostListRepository extends AbstractRepository implements PostListRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostList::class);
    }
}
