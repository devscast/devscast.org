<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Content\Symfony\EventSubscriber;

use Infrastructure\Content\Symfony\EventSubscriber\SitemapEventSubscriber;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Tests\EventSubscriberTest;

/**
 * class SitemapEventSubscriberTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SitemapEventSubscriberTest extends EventSubscriberTest
{
    public function testIsSubscribedToRightEvents(): void
    {
        $this->assertSame(
            [
                SitemapPopulateEvent::class,
            ],
            array_keys(SitemapEventSubscriber::getSubscribedEvents())
        );
    }
}
