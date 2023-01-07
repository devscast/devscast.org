<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Entity\PodcastSeason;
use Domain\Content\Repository\PodcastEpisodeRepositoryInterface;
use Domain\Content\ValueObject\ContentStatus;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class PodcastEpisodeRepository.
 *
 * @extends AbstractRepository<PodcastEpisode>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PodcastEpisodeRepository extends AbstractRepository implements PodcastEpisodeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PodcastEpisode::class);
    }

    public function findBySeason(PodcastSeason $season): array
    {
        return $this->findBy(
            [
                'season' => $season,
                'status' => (string)ContentStatus::published(),
                'is_online' => true
            ],
            ['created_at' => 'DESC']
        );
    }
}
