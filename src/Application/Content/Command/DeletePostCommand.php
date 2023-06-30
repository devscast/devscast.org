<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Post;

/**
 * class DeletePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeletePostCommand
{
    public function __construct(
        public readonly Post $_entity
    ) {
    }
}
