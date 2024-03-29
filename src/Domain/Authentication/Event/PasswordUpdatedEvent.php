<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class PasswordUpdatedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordUpdatedEvent
{
    public function __construct(
        public User $user
    ) {
    }
}
