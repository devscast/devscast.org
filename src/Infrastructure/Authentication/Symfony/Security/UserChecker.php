<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Security;

use Application\Authentication\Service\LoginAttemptService;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\LoginAttemptsLimitReachedEvent;
use Domain\Authentication\Exception\TooManyLoginAttemptsException;
use Domain\Authentication\Exception\UserBannedException;
use Domain\Authentication\Exception\UserRegistrationNotConfirmedException;
use Infrastructure\Authentication\Symfony\DomainAuthenticationExceptionTrait;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserChecker.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserChecker implements UserCheckerInterface
{
    use DomainAuthenticationExceptionTrait;

    public function __construct(
        private readonly LoginAttemptService $loginAttemptService,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function checkPreAuth(UserInterface|User $user): void
    {
        if ($user instanceof User && $this->loginAttemptService->limitReachedFor($user)) {
            if ($this->loginAttemptService->countRecentFor($user) === $this->loginAttemptService::ATTEMPTS) {
                $this->dispatcher->dispatch(new LoginAttemptsLimitReachedEvent($user));
            }

            $this->throwDomainException(new TooManyLoginAttemptsException());
        }
    }

    public function checkPostAuth(UserInterface|User $user): void
    {
        if ($user instanceof User && $user->isBanned()) {
            $this->throwDomainException(new UserBannedException());
        }

        if ($user instanceof User && false === $user->isConfirmed()) {
            $this->throwDomainException(new UserRegistrationNotConfirmedException());
        }
    }
}
