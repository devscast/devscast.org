<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Domain\Content\Entity\Podcast\Season;

/**
 * class DeletePodcastSeasonCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DeleteSeasonCommand
{
    public function __construct(
        public Season $_entity
    ) {
    }
}
