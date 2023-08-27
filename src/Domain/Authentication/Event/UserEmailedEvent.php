<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class UserEmailedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class UserEmailedEvent
{
    public function __construct(
        public User $user,
        public string $subject,
        public string $message
    ) {
    }
}
