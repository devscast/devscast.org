<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Tag;

/**
 * class UpdateTagCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTagCommand
{
    public function __construct(
        public readonly Tag $_entity,
        public ?string $name = null
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
