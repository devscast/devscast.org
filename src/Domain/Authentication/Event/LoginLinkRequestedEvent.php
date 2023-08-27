<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * Class LoginLinkRequestedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class LoginLinkRequestedEvent
{
    public function __construct(
        public User $user,
        public object $link
    ) {
    }
}
