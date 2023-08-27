<?php

declare(strict_types=1);

namespace Application\Content\Command\Training;

use Domain\Content\Entity\Training\Video;

/**
 * class DeleteVideoCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DeleteVideoCommand
{
    public function __construct(
        public Video $_entity
    ) {
    }
}
