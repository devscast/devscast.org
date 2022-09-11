<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ResetLoginAttemptsCommand;
use Application\Authentication\Service\LoginAttemptService;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Exception\InvalidResetLoginAttemptsTokenException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class ResetLoginAttemptsHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ResetLoginAttemptsHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly LoginAttemptService $loginAttemptService
    ) {
    }

    public function __invoke(ResetLoginAttemptsCommand $command): void
    {
        /** @var User|null $user */
        $user = $this->repository->findOneByCaseInsensitive([
            'reset_login_attempts_token' => $command->token,
        ]);
        if (null === $user) {
            throw new InvalidResetLoginAttemptsTokenException();
        }

        $this->loginAttemptService->deleteAttemptsFor($user);
    }
}
