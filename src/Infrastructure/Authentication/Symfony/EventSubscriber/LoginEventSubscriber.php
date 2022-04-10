<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\EventSubscriber;

use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\BadPasswordSubmittedEvent;
use Domain\Authentication\Event\LoginAttemptsLimitReachedEvent;
use Domain\Authentication\Event\LoginWithAnotherIpAddressEvent;
use Domain\Authentication\Repository\UserRepository;
use Domain\Authentication\Service\LoginAttemptService;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class LoginEventSubscriber.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoginAttemptService $loginAttempt,
        private readonly UserRepository $repository,
        private readonly EventDispatcherInterface $dispatcher
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
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        $this->loginAttempt->deleteAttemptsFor($user);

        if ($user instanceof User) {
            $ip = (string) $event->getRequest()->getClientIp();
            if ($ip !== $user->getLastLoginIp()) {
                $this->dispatcher->dispatch(new LoginWithAnotherIpAddressEvent($user, $ip));
                $user->setLastLoginIp($ip);
            }
            $user->setLastLoginAt(new \DateTimeImmutable());
            $this->repository->save($user);
        }
    }

    public function onBadPasswordSubmitted(BadPasswordSubmittedEvent $event): void
    {
        $this->loginAttempt->addAttempt($event->user);
    }

    public function onLoginWithAnotherIpAddress(LoginWithAnotherIpAddressEvent $event): void
    {
        // TODO: send email
    }

    public function onLoginAttemptsLimitReached(LoginAttemptsLimitReachedEvent $event): void
    {
        // TODO: send email
    }
}
