<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Security;

use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\LoginAttemptsLimitReachedEvent;
use Domain\Authentication\Service\LoginAttemptService;
use Infrastructure\Authentication\Exception\TooManyLoginAttemptsException;
use Infrastructure\Authentication\Exception\UserBannedException;
use Infrastructure\Authentication\Exception\UserNotFoundException;
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
    public function __construct(
        private readonly LoginAttemptService $loginAttemptService,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function checkPreAuth(UserInterface|User $user): void
    {
        if ($user instanceof User && $this->loginAttemptService->limitReachedFor($user)) {
            $this->dispatcher->dispatch(new LoginAttemptsLimitReachedEvent($user));
            throw new TooManyLoginAttemptsException();
        }
    }

    public function checkPostAuth(UserInterface|User $user): void
    {
        if ($user instanceof User && $user->isBanned()) {
            throw new UserBannedException();
        }

        if ($user instanceof User && false === $user->isConfirmed()) {
            throw new UserNotFoundException();
        }
    }
}
