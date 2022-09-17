<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * class UnbanUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UnbanUserCommand
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
