<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ConfirmResetPasswordCommand;
use Application\Authentication\Service\LoginAttemptService;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\ResetPasswordConfirmedEvent;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Authentication\Doctrine\Repository\ResetPasswordTokenRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class ConfirmResetPasswordHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ConfirmResetPasswordHandler
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UserRepositoryInterface $userRepository,
        private readonly ResetPasswordTokenRepository $tokenRepository,
        private readonly LoginAttemptService $loginAttemptService,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(ConfirmResetPasswordCommand $command): void
    {
        /** @var User|null $user */
        $user = $command->token->getOwner();
        if (null !== $user) {
            $this->userRepository->upgradePassword(
                user: $user,
                newHashedPassword: $this->hasher->hashPassword(
                    user: $user,
                    plainPassword: (string) $command->password
                )
            );

            /*
             * it can happen that the user wants to reset his password before confirming his email,
             * if he managed to do it then the email address he uses belongs to him and therefore
             * we can make an implicit validation of the email
             */
            if (false === $user->isIsEmailVerified()) {
                $user->setEmailVerificationToken(null)
                    ->setIsEmailVerified(true);
                $this->userRepository->save($user);
            }

            $this->tokenRepository->delete($command->token);
            $this->loginAttemptService->deleteAttemptsFor($user);
            $this->dispatcher->dispatch(new ResetPasswordConfirmedEvent($user));
        }
    }
}
