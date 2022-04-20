<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\TwoFactorAuthDisabledEvent;
use Domain\Authentication\Event\TwoFactorAuthEnabledEvent;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TwoFactorAuthEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TwoFactorAuthEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly TranslatorInterface $translator
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TwoFactorAuthEnabledEvent::class => 'onTwoFactorAuthEnabled',
            TwoFactorAuthDisabledEvent::class => 'onTwoFactorAuthDisabled',
        ];
    }

    public function onTwoFactorAuthEnabled(TwoFactorAuthEnabledEvent $event): void
    {
        $user = $event->user;
        $email = $this->createEmail(
            user: $user,
            template: 'domain/authentication/mail/2fa_enabled.mail.twig',
            subject: 'authentication.mails.subjects.2fa_enabled'
        );
        $this->mailer->send($email);
    }

    public function onTwoFactorAuthDisabled(TwoFactorAuthDisabledEvent $event): void
    {
        $user = $event->user;
        $email = $this->createEmail(
            user: $user,
            template: 'domain/authentication/mail/2fa_disabled.mail.twig',
            subject: 'authentication.mails.subjects.2fa_disabled'
        );
        $this->mailer->send($email);
    }

    private function createEmail(User $user, string $template, string $subject): Email
    {
        return $this->mailer
            ->createEmail(
                template: $template,
                data: [
                    'user' => $user,
                ]
            )->subject($this->translator->trans(
                id: $subject,
                parameters: [],
                domain: 'authentication'
            ))
            ->to(new Address((string) $user->getEmail(), (string) $user->getUsername()));
    }
}
