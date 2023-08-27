<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Podcast\Progression;

/**
 * class UpdateProgressionCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateProgressionCommand
{
    public function __construct(
        public readonly Progression $_entity,
        public int $progress = 0
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
