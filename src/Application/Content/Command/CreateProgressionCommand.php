<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;

/**
 * class CreateProgressionCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateProgressionCommand
{
    public function __construct(
        public ?User $owner = null,
        public ?Content $target = null,
        public int $progress = 0
    ) {
    }
}
