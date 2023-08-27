<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class UserRegistrationConfirmedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class UserRegistrationConfirmedEvent
{
    public function __construct(
        public User $user,
        public bool $is_oauth = false,
        public ?string $oauth_type = null
    ) {
    }
}
