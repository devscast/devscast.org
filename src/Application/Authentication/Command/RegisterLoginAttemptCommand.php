<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class RegisterLoginAttemptCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RegisterLoginAttemptCommand
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
