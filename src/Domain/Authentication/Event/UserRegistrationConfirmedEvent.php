<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class UserRegistrationConfirmedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserRegistrationConfirmedEvent
{
    public function __construct(
        public readonly User $user,
        public readonly bool $is_oauth = false,
        public readonly ?string $oauth_type = null
    ) {
    }
}
