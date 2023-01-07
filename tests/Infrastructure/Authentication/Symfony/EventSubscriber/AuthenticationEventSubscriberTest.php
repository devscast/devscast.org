<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Event\BadPasswordSubmittedEvent;
use Domain\Authentication\Event\DefaultPasswordCreatedEvent;
use Domain\Authentication\Event\LoginAttemptsLimitReachedEvent;
use Domain\Authentication\Event\LoginLinkRequestedEvent;
use Domain\Authentication\Event\LoginWithAnotherIpAddressEvent;
use Domain\Authentication\Event\PasswordUpdatedEvent;
use Domain\Authentication\Event\ResetPasswordConfirmedEvent;
use Domain\Authentication\Event\ResetPasswordRequestedEvent;
use Domain\Authentication\Event\UserEmailedEvent;
use Domain\Authentication\Event\UserRegisteredEvent;
use Domain\Authentication\Event\UserRegistrationConfirmedEvent;
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
        $this->assertSame(
            [
                InteractiveLoginEvent::class,
                BadPasswordSubmittedEvent::class,
                LoginWithAnotherIpAddressEvent::class,
                LoginAttemptsLimitReachedEvent::class,
                LoginLinkRequestedEvent::class,
                ResetPasswordConfirmedEvent::class,
                ResetPasswordRequestedEvent::class,
                DefaultPasswordCreatedEvent::class,
                PasswordUpdatedEvent::class,
                UserRegisteredEvent::class,
                UserRegistrationConfirmedEvent::class,
                UserEmailedEvent::class,
            ],
            array_keys(AuthenticationEventSubscriber::getSubscribedEvents())
        );
    }
}
