<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class UserEmailedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserEmailedEvent
{
    public function __construct(
        public readonly User $user,
        public readonly string $subject,
        public readonly string $message
    ) {
    }
}
