<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\EventSubscriber;

use Application\Authentication\Command\RegisterLoginAttemptCommand;
use Application\Authentication\Command\RegisterLoginIpAddressCommand;
use Devscast\Bundle\DddBundle\Infrastructure\MailerHelper;
use Domain\Authentication\Entity\User;
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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AuthenticationEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MailerHelper $mailer,
        private readonly MessageBusInterface $bus
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
            LoginLinkRequestedEvent::class => 'onLoginLinkRequested',
            ResetPasswordConfirmedEvent::class => 'onResetPasswordConfirmed',
            ResetPasswordRequestedEvent::class => 'onResetPasswordRequested',
            DefaultPasswordCreatedEvent::class => 'onDefaultPasswordCreated',
            PasswordUpdatedEvent::class => 'onPasswordUpdated',
            UserRegisteredEvent::class => 'onUserRegistered',
            UserRegistrationConfirmedEvent::class => 'onUserRegistrationConfirmed',
            UserEmailedEvent::class => 'onUserEmailed',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();
        $ip = (string) $event->getRequest()->getClientIp();
        $this->bus->dispatch(new RegisterLoginIpAddressCommand($user, $ip));
    }

    public function onBadPasswordSubmitted(BadPasswordSubmittedEvent $event): void
    {
        $this->bus->dispatch(new RegisterLoginAttemptCommand($event->user));
    }

    public function onLoginWithAnotherIpAddress(LoginWithAnotherIpAddressEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/login_with_another_ip_address.mail.twig',
            subject: 'authentication.mails.subjects.login_with_another_ip_address',
            domain: 'authentication'
        );
    }

    public function onPasswordUpdated(PasswordUpdatedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/password_updated.mail.twig',
            subject: 'authentication.mails.subjects.password_updated',
            domain: 'authentication'
        );
    }

    public function onDefaultPasswordCreated(DefaultPasswordCreatedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/default_password_created.mail.twig',
            subject: 'authentication.mails.subjects.password_updated',
            domain: 'authentication'
        );
    }

    public function onLoginAttemptsLimitReached(LoginAttemptsLimitReachedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/login_attempts_limit_reached.mail.twig',
            subject: 'authentication.mails.subjects.login_attempts_limit_reached',
            domain: 'authentication'
        );
    }

    public function onLoginLinkRequested(LoginLinkRequestedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/login_link.mail.twig',
            subject: 'authentication.mails.subjects.login_link_requested',
            subject_parameters: [
                '%name%' => $event->user->getUsername(),
            ],
            domain: 'authentication'
        );
    }

    public function onResetPasswordConfirmed(ResetPasswordConfirmedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/reset_password_confirmed.mail.twig',
            subject: 'authentication.mails.subjects.reset_password_confirmed',
            subject_parameters: [
                '%name%' => $event->user->getUsername(),
            ],
            domain: 'authentication'
        );
    }

    public function onResetPasswordRequested(ResetPasswordRequestedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/reset_password_request.mail.twig',
            subject: 'authentication.mails.subjects.reset_password_requested',
            domain: 'authentication'
        );
    }

    public function onUserEmailed(UserEmailedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@admin/domain/authentication/mail/admin_contact.mail.twig',
            subject: $event->subject,
            domain:  'authentication'
        );
    }

    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/registration_confirmation.mail.twig',
            subject: 'authentication.mails.subjects.registration_confirmation',
            domain: 'authentication'
        );
    }

    public function onUserRegistrationConfirmed(UserRegistrationConfirmedEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/registration_confirmed.mail.twig',
            subject: 'authentication.mails.subjects.registration_confirmed',
            domain: 'authentication'
        );
    }
}
