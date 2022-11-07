<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Progression;

/**
 * class UpdateProgressionCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateProgressionCommand
{
    public function __construct(
        public readonly Progression $state,
        public int $progress = 0
    ) {
        Mapper::hydrate($this->state, $this);
    }
}
