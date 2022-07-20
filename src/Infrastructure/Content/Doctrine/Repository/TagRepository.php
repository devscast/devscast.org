<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Tag;
use Domain\Content\Repository\TagRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class TagRepository.
 *
 * @extends AbstractRepository<Tag>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }
}
