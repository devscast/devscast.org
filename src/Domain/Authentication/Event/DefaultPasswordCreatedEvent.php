<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class DefaultPasswordCreatedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DefaultPasswordCreatedEvent
{
    public function __construct(
        public User $user,
        public int $password
    ) {
    }
}
