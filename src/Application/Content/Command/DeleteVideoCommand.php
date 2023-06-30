<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Video;

/**
 * class DeleteVideoCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteVideoCommand
{
    public function __construct(
        public readonly Video $_entity
    ) {
    }
}
