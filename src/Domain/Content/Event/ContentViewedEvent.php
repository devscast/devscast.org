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
final readonly class ContentViewedEvent
{
    public function __construct(
        public Content $target,
        public string $ip,
        public ?User $owner = null
    ) {
    }
}
