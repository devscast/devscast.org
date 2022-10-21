<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Comment;
use Domain\Content\Entity\Content;

/**
 * class CreateCommentCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateCommentCommand
{
    public function __construct(
        public readonly User $owner,
        public readonly Content $target,
        public ?Comment $parent = null,
        public ?string $content = null,
    ) {
    }
}
