<?php

declare(strict_types=1);

namespace Domain\Content\Event;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;

/**
 * class ContentViewedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentViewedEvent
{
    public function __construct(
        public readonly Content $target,
        public readonly string $ip,
        public readonly ?User $owner = null
    ) {
    }
}
