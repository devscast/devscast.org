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
        public readonly User $owner,
        public readonly Content $target,
        public int $progress = 0
    ) {
    }
}
