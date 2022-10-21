<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Comment;

/**
 * class UpdateCommentCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCommentCommand
{
    public function __construct(
        public readonly Comment $comment,
        public ?string $content = null,
    ) {
        Mapper::hydrate($this->comment, $this);
    }
}
