<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;

/**
 * class CreatePostListCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePostListCommand
{
    public function __construct(
        public ?User $owner = null,
        public ?string $name = null,
        public ?string $description = null,
        public bool $is_public = false
    ) {
    }
}
