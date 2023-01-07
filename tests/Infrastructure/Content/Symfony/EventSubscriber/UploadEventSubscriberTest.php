<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Content\Symfony\EventSubscriber;

use Infrastructure\Content\Symfony\EventSubscriber\UploadEventSubscriber;
use Tests\EventSubscriberTest;
use Vich\UploaderBundle\Event\Events;

/**
 * class UploadEventSubscriberTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UploadEventSubscriberTest extends EventSubscriberTest
{
    public function testIsSubscribedToRightEvents(): void
    {
        $this->assertSame(
            [
                Events::POST_INJECT,
            ],
            array_keys(UploadEventSubscriber::getSubscribedEvents())
        );
    }
}
