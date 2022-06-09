<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Event\TwoFactorAuthDisabledEvent;
use Domain\Authentication\Event\TwoFactorAuthEnabledEvent;
use Infrastructure\Authentication\Symfony\EventSubscriber\TwoFactorAuthEventSubscriber;
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
        $events = TwoFactorAuthEventSubscriber::getSubscribedEvents();

        $this->assertArrayHasKey(TwoFactorAuthEnabledEvent::class, $events);
        $this->assertArrayHasKey(TwoFactorAuthDisabledEvent::class, $events);
    }
}
