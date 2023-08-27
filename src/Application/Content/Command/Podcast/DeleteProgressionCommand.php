<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Domain\Content\Entity\Podcast\Progression;

/**
 * class DeleteProgressionCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DeleteProgressionCommand
{
    public function __construct(
        public Progression $_entity
    ) {
    }
}
