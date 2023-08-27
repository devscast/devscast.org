<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\EventSubscriber;

use Devscast\Bundle\DddBundle\Infrastructure\MailerHelper;
use Domain\Authentication\Event\TwoFactorDisabledEvent;
use Domain\Authentication\Event\TwoFactorEnabledEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class TwoFactorEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class TwoFactorEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private MailerHelper $mailer,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TwoFactorEnabledEvent::class => 'onTwoFactorEnabled',
            TwoFactorDisabledEvent::class => 'onTwoFactorDisabled',
        ];
    }

    public function onTwoFactorDisabled(TwoFactorDisabledEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/two_factor_enabled.mail.twig',
            subject: 'authentication.mails.subjects.two_factor_enabled',
            domain: 'authentication'
        );
    }

    public function onTwoFactorEnabled(TwoFactorEnabledEvent $event): void
    {
        $this->mailer->sendNotificationEmail(
            $event,
            template: '@app/domain/authentication/mail/two_factor_disabled.mail.twig',
            subject: 'authentication.mails.subjects.two_factor_disabled',
            domain: 'authentication'
        );
    }
}
