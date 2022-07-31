<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Event\TwoFactorDisabledEvent;
use Domain\Authentication\Event\TwoFactorEnabledEvent;
use Infrastructure\Authentication\Symfony\EventSubscriber\TwoFactorEventSubscriber;
use Tests\EventSubscriberTest;

/**
 * Class TwoFactorAuthSubscriberTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TwoFactorAuthSubscriberTest extends EventSubscriberTest
{
    public function testIsSubscribedToRightEvents(): void
    {
        $events = TwoFactorEventSubscriber::getSubscribedEvents();

        $this->assertArrayHasKey(TwoFactorEnabledEvent::class, $events);
        $this->assertArrayHasKey(TwoFactorDisabledEvent::class, $events);
    }
}
