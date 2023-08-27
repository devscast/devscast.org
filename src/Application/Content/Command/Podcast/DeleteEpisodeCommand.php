<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Domain\Content\Entity\Podcast\Episode;

/**
 * class DeletePodcastEpisodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DeleteEpisodeCommand
{
    public function __construct(
        public Episode $_entity
    ) {
    }
}
