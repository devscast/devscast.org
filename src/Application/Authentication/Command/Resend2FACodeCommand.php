<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class Resend2FACodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Resend2FACodeCommand
{
    public function __construct(
        public readonly string $ip,
        public readonly User $user
    ) {
    }
}
