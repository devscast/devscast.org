<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\PodcastEpisode;

/**
 * class DeletePodcastEpisodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeletePodcastEpisodeCommand
{
    public function __construct(
        public readonly PodcastEpisode $_entity
    ) {
    }
}
