<?php

declare(strict_types=1);

namespace Domain\Authentication\Event;

use Domain\Authentication\Entity\User;

/**
 * Class BadPasswordSubmittedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class BadPasswordSubmittedEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
