<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * class UserUnbannedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserUnbannedEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
