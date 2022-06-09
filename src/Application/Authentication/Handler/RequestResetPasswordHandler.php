<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RequestResetPasswordCommand;
use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Exception\ResetPasswordOngoingException;
use Domain\Authentication\Exception\UserNotFoundException;
use Domain\Authentication\Repository\ResetPasswordTokenRepositoryInterface;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        private readonly Mailer $mailer,
        private readonly ResetPasswordTokenRepositoryInterface $tokenRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function __invoke(RequestResetPasswordCommand $command): void
    {
        $user = $this->findUserByEmail($command->email);
        $token = $this->findOngoingRequestTokenFor($user);

        if (null === $token) {
            $token = new ResetPasswordToken();
        }

        $token->setUser($user);
        $this->tokenRepository->save($token);

        $this->sendResetPasswordInstructionEmail($token, $user);
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

    private function sendResetPasswordInstructionEmail(?ResetPasswordToken $token, User $user): void
    {
        $email = $this->mailer
            ->createEmail(
                template: 'domain/authentication/mail/reset_password_request.mail.twig',
                data: [
                    'token' => $token,
                ]
            )->subject($this->translator->trans(
                id: 'authentication.mails.subjects.reset_password_requested',
                parameters: [],
                domain: 'authentication'
            ))
            ->to(new Address((string) $user->getEmail(), (string) $user->getUsername()));

        $this->mailer->send($email);
    }
}
