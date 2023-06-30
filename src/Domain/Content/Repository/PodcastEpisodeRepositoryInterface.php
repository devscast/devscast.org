<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Content\Entity\PodcastSeason;

/**
 * Interface PodcastEpisodeRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface PodcastEpisodeRepositoryInterface extends DataRepositoryInterface
{
    public function findBySeason(PodcastSeason $season): array;
}
