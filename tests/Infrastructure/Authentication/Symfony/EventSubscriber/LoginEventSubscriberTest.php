<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Event\BadPasswordSubmittedEvent;
use Domain\Authentication\Event\LoginAttemptsLimitReachedEvent;
use Domain\Authentication\Event\LoginWithAnotherIpAddressEvent;
use Domain\Authentication\Event\ResetPasswordConfirmedEvent;
use Infrastructure\Authentication\Symfony\EventSubscriber\LoginEventSubscriber;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Tests\EventSubscriberTest;

/**
 * Class LoginEventSubscriberTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginEventSubscriberTest extends EventSubscriberTest
{
    public function testIsSubscribedToRightEvents(): void
    {
        $events = LoginEventSubscriber::getSubscribedEvents();

        $this->assertArrayHasKey(InteractiveLoginEvent::class, $events);
        $this->assertArrayHasKey(BadPasswordSubmittedEvent::class, $events);
        $this->assertArrayHasKey(LoginWithAnotherIpAddressEvent::class, $events);
        $this->assertArrayHasKey(LoginAttemptsLimitReachedEvent::class, $events);
        $this->assertArrayHasKey(ResetPasswordConfirmedEvent::class, $events);
    }
}
