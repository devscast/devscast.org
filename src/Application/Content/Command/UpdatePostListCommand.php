<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\PostList;

/**
 * class UpdatePostListCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostListCommand
{
    public function __construct(
        public readonly PostList $state,
        public ?string $name = null,
        public ?string $description = null,
        public bool $is_public = false
    ) {
        Mapper::hydrate($this->state, $this);
    }
}
