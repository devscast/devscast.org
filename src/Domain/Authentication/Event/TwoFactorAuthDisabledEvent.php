<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * Class TwoFactorAuthDisabledEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TwoFactorAuthDisabledEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
