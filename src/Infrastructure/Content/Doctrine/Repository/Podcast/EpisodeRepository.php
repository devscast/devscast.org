<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository\Podcast;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Podcast\Episode;
use Domain\Content\Entity\Podcast\Season;
use Domain\Content\Enum\Status;
use Domain\Content\Repository\Podcast\EpisodeRepositoryInterface;

/**
 * class PodcastEpisodeRepository.
 *
 * @extends AbstractRepository<Episode>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EpisodeRepository extends AbstractRepository implements EpisodeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Episode::class);
    }

    public function findBySeason(Season $season): array
    {
        return $this->findBy(
            [
                'season' => $season,
                'status' => (string) Status::PUBLISHED->value,
                'is_online' => true,
            ],
            [
                'created_at' => 'DESC',
            ]
        );
    }
}
