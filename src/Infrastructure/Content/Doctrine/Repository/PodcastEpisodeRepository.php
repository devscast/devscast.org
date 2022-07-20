<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Repository\PodcastEpisodeRepositoryInterface;
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
}
