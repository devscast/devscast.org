<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\PostList;

/**
 * class UpdatePostListCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostListCommand
{
    public function __construct(
        public readonly PostList $_entity,
        public ?string $name = null,
        public ?string $description = null,
        public bool $is_public = false
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
