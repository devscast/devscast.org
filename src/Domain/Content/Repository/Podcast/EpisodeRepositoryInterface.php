<?php

declare(strict_types=1);

namespace Domain\Content\Repository\Podcast;

use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Content\Entity\Podcast\Season;

/**
 * Interface PodcastEpisodeRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface EpisodeRepositoryInterface extends DataRepositoryInterface
{
    public function findBySeason(Season $season): array;
}
