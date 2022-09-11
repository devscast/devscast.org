<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Entity\User;

/**
 * Class ResetPasswordRequestedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordRequestedEvent
{
    public function __construct(
        public readonly User $user,
        public readonly ResetPasswordToken $token
    ) {
    }
}
