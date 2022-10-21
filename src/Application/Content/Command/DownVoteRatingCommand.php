<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Rating;

/**
 * class DownVoteRatingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DownVoteRatingCommand
{
    public function __construct(
        public readonly Rating $rating,
    ) {
        Mapper::hydrate($this->rating, $this);
    }
}
