<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Rating;
use Domain\Content\Repository\RatingRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class RatingRepository.
 *
 * @extends AbstractRepository<Rating>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RatingRepository extends AbstractRepository implements RatingRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }
}
