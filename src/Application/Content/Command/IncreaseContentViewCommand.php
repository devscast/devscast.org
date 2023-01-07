<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;

/**
 * class IncreaseContentViewCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class IncreaseContentViewCommand
{
    public function __construct(
        public readonly Content $target,
        public readonly string $ip,
        public readonly ?User $owner
    ) {
    }
}
