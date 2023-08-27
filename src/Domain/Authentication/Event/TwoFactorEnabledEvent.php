<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * Class TwoFactorEnabledEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class TwoFactorEnabledEvent
{
    public function __construct(
        public User $user
    ) {
    }
}
