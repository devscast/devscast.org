<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Comment;

/**
 * class ReplyToCommentCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ReplyToCommentCommand
{
    public function __construct(
        public readonly User $owner,
        public Comment $parent,
        public ?string $content = null
    ) {
    }
}
