<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\PodcastSeason;

/**
 * class DeletePodcastSeasonCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeletePodcastSeasonCommand
{
    public function __construct(
        public readonly PodcastSeason $season
    ) {
    }
}
