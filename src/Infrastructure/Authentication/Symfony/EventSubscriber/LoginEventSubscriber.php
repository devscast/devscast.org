<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\EventSubscriber;

use Application\Authentication\Command\RegisterLoginAttemptCommand;
use Application\Authentication\Command\RegisterLoginIpAddressCommand;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\BadPasswordSubmittedEvent;
use Domain\Authentication\Event\LoginAttemptsLimitReachedEvent;
use Domain\Authentication\Event\LoginWithAnotherIpAddressEvent;
use Domain\Authentication\Event\ResetPasswordConfirmedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class LoginEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            InteractiveLoginEvent::class => 'onInteractiveLogin',
            BadPasswordSubmittedEvent::class => 'onBadPasswordSubmitted',
            LoginWithAnotherIpAddressEvent::class => 'onLoginWithAnotherIpAddress',
            LoginAttemptsLimitReachedEvent::class => 'onLoginAttemptsLimitReached',
            ResetPasswordConfirmedEvent::class => 'onResetPasswordConfirmed',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();
        $ip = (string) $event->getRequest()->getClientIp();
        $this->commandBus->dispatch(new RegisterLoginIpAddressCommand($user, $ip));
    }

    public function onBadPasswordSubmitted(BadPasswordSubmittedEvent $event): void
    {
        $this->commandBus->dispatch(new RegisterLoginAttemptCommand($event->user));
    }

    public function onLoginWithAnotherIpAddress(LoginWithAnotherIpAddressEvent $event): void
    {
        // TODO: send email
    }

    public function onLoginAttemptsLimitReached(LoginAttemptsLimitReachedEvent $event): void
    {
        // TODO: send email
    }

    public function onResetPasswordConfirmed(ResetPasswordConfirmedEvent $event): void
    {
        // TODO: send email
    }
}
