<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * Class LoggedInWithAnotherIpAddressEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginWithAnotherIpAddressEvent
{
    public function __construct(
        public readonly User $user,
        public readonly string $ip
    ) {
    }
}
