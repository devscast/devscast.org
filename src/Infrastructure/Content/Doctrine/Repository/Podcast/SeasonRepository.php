<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository\Podcast;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Podcast\Season;
use Domain\Content\Repository\Podcast\SeasonRepositoryInterface;

/**
 * class PodcastSeasonRepository.
 *
 * @extends AbstractRepository<Season>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SeasonRepository extends AbstractRepository implements SeasonRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }
}
