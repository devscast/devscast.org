<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Content\Symfony\EventSubscriber;

use Domain\Content\Event\ContentViewedEvent;
use Domain\Content\Event\ContentViewMilestoneReachedEvent;
use Infrastructure\Content\Symfony\EventSubscriber\ContentEventSubscriber;
use Tests\EventSubscriberTest;

/**
 * class ContentEventSubscriberTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentEventSubscriberTest extends EventSubscriberTest
{
    public function testIsSubscribedToRightEvents(): void
    {
        $this->assertSame(
            [
                ContentViewedEvent::class,
                ContentViewMilestoneReachedEvent::class,
            ],
            array_keys(ContentEventSubscriber::getSubscribedEvents())
        );
    }
}
