<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Content;
use Domain\Content\Repository\ContentRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class ContentRepository.
 *
 * @extends AbstractRepository<Content>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentRepository extends AbstractRepository implements ContentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }
}
