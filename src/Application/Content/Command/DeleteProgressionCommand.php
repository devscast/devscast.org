<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Progression;

/**
 * class DeleteProgressionCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteProgressionCommand
{
    public function __construct(
        public readonly Progression $progression
    ) {
    }
}
