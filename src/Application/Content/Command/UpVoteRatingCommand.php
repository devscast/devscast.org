<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Rating;

/**
 * class UpVoteRatingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpVoteRatingCommand
{
    public function __construct(
        public readonly Rating $_entity,
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
