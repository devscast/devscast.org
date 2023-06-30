<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Comment;

/**
 * class DeleteCommentCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteCommentCommand
{
    public function __construct(
        public readonly Comment $_entity
    ) {
    }
}
