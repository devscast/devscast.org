<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Event\BadPasswordSubmittedEvent;
use Domain\Authentication\Event\DefaultPasswordCreatedEvent;
use Domain\Authentication\Event\LoginAttemptsLimitReachedEvent;
use Domain\Authentication\Event\LoginWithAnotherIpAddressEvent;
use Domain\Authentication\Event\PasswordUpdatedEvent;
use Domain\Authentication\Event\ResetPasswordConfirmedEvent;
use Infrastructure\Authentication\Symfony\EventSubscriber\AuthenticationEventSubscriber;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Tests\EventSubscriberTest;

/**
 * Class AuthenticationEventSubscriberTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AuthenticationEventSubscriberTest extends EventSubscriberTest
{
    public function testIsSubscribedToRightEvents(): void
    {
        $events = AuthenticationEventSubscriber::getSubscribedEvents();

        $this->assertArrayHasKey(InteractiveLoginEvent::class, $events);
        $this->assertArrayHasKey(BadPasswordSubmittedEvent::class, $events);
        $this->assertArrayHasKey(LoginWithAnotherIpAddressEvent::class, $events);
        $this->assertArrayHasKey(LoginAttemptsLimitReachedEvent::class, $events);
        $this->assertArrayHasKey(ResetPasswordConfirmedEvent::class, $events);
        $this->assertArrayHasKey(DefaultPasswordCreatedEvent::class, $events);
        $this->assertArrayHasKey(PasswordUpdatedEvent::class, $events);
    }
}
