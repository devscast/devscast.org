<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository\Podcast;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Podcast\Progression;
use Domain\Content\Repository\Podcast\ProgressionRepositoryInterface;

/**
 * class ProgressionRepository.
 *
 * @extends AbstractRepository<Progression>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ProgressionRepository extends AbstractRepository implements ProgressionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Progression::class);
    }
}
