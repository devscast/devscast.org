<?php

declare(strict_types=1);

namespace Domain\Authentication\Service;

use Domain\Authentication\Entity\LoginAttempt;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\LoginAttemptRepository;

/**
 * Class LoginAttemptService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginAttemptService
{
    private const ATTEMPTS = 3;

    public function __construct(
        private readonly LoginAttemptRepository $repository
    ) {
    }

    public function addAttempt(User $user): void
    {
        $this->repository->save(LoginAttempt::createFor($user));
    }

    public function deleteAttemptsFor(User $user): void
    {
        $this->repository->deleteAttemptsFor($user);
    }

    public function limitReachedFor(User $user): bool
    {
        return $this->repository->countRecentFor($user, 30) >= self::ATTEMPTS;
    }
}
