<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ConfirmResetPasswordCommand;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Authentication\Doctrine\Repository\ResetPasswordTokenRepository;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ConfirmResetPasswordHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ConfirmResetPasswordHandler
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly Mailer $mailer,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UserRepositoryInterface $userRepository,
        private readonly ResetPasswordTokenRepository $tokenRepository
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

            $this->tokenRepository->delete($command->token);
            $this->sendResetPasswordConfirmedEmail($user);
        }
    }

    private function sendResetPasswordConfirmedEmail(User $user): void
    {
        $email = $this->mailer
            ->createEmail(
                template: 'domain/authentication/mail/reset_password_confirmed.mail.twig',
                data: [
                    'user' => $user,
                ]
            )->subject($this->translator->trans(
                id: 'authentication.mails.subjects.reset_password_confirmed',
                parameters: [
                    '%name%' => $user->getUsername(),
                ],
                domain: 'authentication'
            ))
            ->to(new Address((string) $user->getEmail(), (string) $user->getUsername()));

        $this->mailer->send($email);
    }
}
