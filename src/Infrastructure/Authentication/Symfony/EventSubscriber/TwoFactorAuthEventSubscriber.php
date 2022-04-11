<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Event\TwoFactorAuthDisabledEvent;
use Domain\Authentication\Event\TwoFactorAuthEnabledEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class TwoFactorAuthEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TwoFactorAuthEventSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            TwoFactorAuthEnabledEvent::class => 'onTwoFactorAuthEnabled',
            TwoFactorAuthDisabledEvent::class => 'onTwoFactorAuthDisabled',
        ];
    }

    public function onTwoFactorAuthEnabled(TwoFactorAuthEnabledEvent $event): void
    {
    }

    public function onTwoFactorAuthDisabled(TwoFactorAuthDisabledEvent $event): void
    {
    }
}
