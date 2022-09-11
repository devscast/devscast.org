<?php

declare(strict_types=1);

namespace Application\Authentication\Service;

use Domain\Authentication\Entity\LoginAttempt;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\LoginAttemptRepositoryInterface;
use Domain\Authentication\Repository\UserRepositoryInterface;

/**
 * Class LoginAttemptService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginAttemptService
{
    public const ATTEMPTS = 3;

    public function __construct(
        private readonly LoginAttemptRepositoryInterface $repository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly CodeGeneratorService $codeGeneratorService
    ) {
    }

    public function addAttempt(User $user): void
    {
        $this->repository->save(LoginAttempt::createFor($user));

        if (null === $user->getResetLoginAttemptsToken()) {
            $token = $this->codeGeneratorService->generateToken();
            $user->setResetLoginAttemptsToken($token);
            $this->userRepository->save($user);
        }
    }

    public function deleteAttemptsFor(User $user): void
    {
        $this->repository->deleteAttemptsFor($user);

        if (null !== $user->getResetLoginAttemptsToken()) {
            $user->setResetLoginAttemptsToken(null);
            $this->userRepository->save($user);
        }
    }

    public function limitReachedFor(User $user): bool
    {
        return $this->repository->countRecentFor($user) >= self::ATTEMPTS;
    }

    public function countRecentFor(User $user): int
    {
        return $this->repository->countRecentFor($user);
    }
}
