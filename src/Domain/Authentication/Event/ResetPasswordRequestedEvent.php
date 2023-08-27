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
final readonly class ResetPasswordRequestedEvent
{
    public function __construct(
        public User $user,
        public ResetPasswordToken $token
    ) {
    }
}
