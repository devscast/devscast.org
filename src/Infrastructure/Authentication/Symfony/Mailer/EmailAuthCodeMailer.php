<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Mailer;

use Domain\Authentication\Entity\User;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Scheb\TwoFactorBundle\Mailer\AuthCodeMailerInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EmailAuthCodeMailer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EmailAuthCodeMailer implements AuthCodeMailerInterface
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly TranslatorInterface $translator
    ) {
    }

    /**
     * @psalm-param User $user
     */
    public function sendAuthCode(TwoFactorInterface $user): void
    {
        $email = $this->mailer->createEmail(
            template: 'domain/authentication/mail/2fa_auth_code.mail.twig',
            data: [
                'user' => $user,
            ]
        )->subject($this->translator->trans(
            id: 'authentication.mails.subjects.2fa_auth_code',
            parameters: [],
            domain: 'authentication'
        ))->to(new Address($user->getEmailAuthRecipient(), (string) $user->getUsername()));

        $this->mailer->send($email);
    }
}
