<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\PostList;

/**
 * class DeletePostListCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeletePostListCommand
{
    public function __construct(
        public readonly PostList $list
    ) {
    }
}
