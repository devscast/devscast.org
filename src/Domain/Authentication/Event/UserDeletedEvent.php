<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class UserDeletedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserDeletedEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
