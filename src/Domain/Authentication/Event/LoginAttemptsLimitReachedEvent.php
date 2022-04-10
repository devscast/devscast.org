<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * Class LoginAttemptsLimitReachedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginAttemptsLimitReachedEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
