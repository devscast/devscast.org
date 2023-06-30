<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Comment;

/**
 * class UpdateCommentCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCommentCommand
{
    public function __construct(
        public readonly Comment $_entity,
        public ?string $content = null,
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
