<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RequestResetPasswordCommand;
use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\ResetPasswordRequestedEvent;
use Domain\Authentication\Exception\ResetPasswordOngoingException;
use Domain\Authentication\Exception\UserNotFoundException;
use Domain\Authentication\Repository\ResetPasswordTokenRepositoryInterface;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class RequestResetPasswordHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class RequestResetPasswordHandler
{
    private const EXPIRE_IN = 30;

    public function __construct(
        private readonly ResetPasswordTokenRepositoryInterface $tokenRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(RequestResetPasswordCommand $command): void
    {
        $user = $this->findUserByEmail($command->email);
        $token = $this->findOngoingRequestTokenFor($user);

        if (null === $token) {
            $token = new ResetPasswordToken();
        }

        $token->setOwner($user);
        $this->tokenRepository->save($token);
        $this->dispatcher->dispatch(new ResetPasswordRequestedEvent($user, $token));
    }

    private function findUserByEmail(?string $email): User
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneByEmail((string) $email);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    private function findOngoingRequestTokenFor(User $user): ?ResetPasswordToken
    {
        /** @var ResetPasswordToken|null $token */
        $token = $this->tokenRepository->findFor($user);
        if (null !== $token && ! $token->isExpired(self::EXPIRE_IN)) {
            throw new ResetPasswordOngoingException();
        }

        return $token;
    }
}
