<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Progression;
use Domain\Content\Repository\ProgressionRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

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
