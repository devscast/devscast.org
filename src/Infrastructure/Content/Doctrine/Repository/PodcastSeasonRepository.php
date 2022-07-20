<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\PodcastSeason;
use Domain\Content\Repository\PodcastSeasonRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class PodcastSeasonRepository.
 *
 * @extends AbstractRepository<PodcastSeason>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PodcastSeasonRepository extends AbstractRepository implements PodcastSeasonRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PodcastSeason::class);
    }
}
