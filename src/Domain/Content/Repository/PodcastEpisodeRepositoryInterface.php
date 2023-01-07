<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Entity\PodcastSeason;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface PodcastEpisodeRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface PodcastEpisodeRepositoryInterface extends DataRepositoryInterface
{
    public function findBySeason(PodcastSeason $season): array;
}
