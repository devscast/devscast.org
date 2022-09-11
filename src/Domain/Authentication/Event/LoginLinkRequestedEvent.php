<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * Class LoginLinkRequestedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginLinkRequestedEvent
{
    public function __construct(
        public readonly User $user,
        public readonly object $link
    ) {
    }
}
