<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Mailer;

use Devscast\Bundle\DddBundle\Infrastructure\MailerHelper;
use Domain\Authentication\Entity\User;
use Scheb\TwoFactorBundle\Mailer\AuthCodeMailerInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TwoFactorEmailCodeMailer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class TwoFactorEmailCodeMailer implements AuthCodeMailerInterface
{
    public function __construct(
        private MailerHelper $mailer,
        private TranslatorInterface $translator
    ) {
    }

    /**
     * @psalm-param User $user
     */
    public function sendAuthCode(TwoFactorInterface $user): void
    {
        $email = $this->mailer->createEmail(
            template: '@app/domain/authentication/mail/two_factor_auth_code.mail.twig',
            data: [
                'user' => $user,
            ]
        )->subject($this->translator->trans(
            id: 'authentication.mails.subjects.two_factor_auth_code',
            parameters: [],
            domain: 'authentication'
        ))->to(new Address($user->getEmailAuthRecipient(), (string) $user->getUsername()));

        $this->mailer->send($email);
    }
}
