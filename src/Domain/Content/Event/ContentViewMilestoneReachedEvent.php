<?php

declare(strict_types=1);

namespace Domain\Content\Event;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;

/**
 * class ContentViewMilestoneReachedEvent.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentViewMilestoneReachedEvent
{
    public function __construct(
        public readonly Content $target,
        public readonly User $user,
    ) {
    }
}
