<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Mailer;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

/**
 * Class Mailer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Mailer
{
    public function __construct(
        private readonly Environment $twig,
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger
    ) {
    }

    public function createEmail(string $template, array $data = []): Email
    {
        $html = $this->twig->render(
            name: $template,
            context: $data + [
                '_format' => 'html',
                '_layout' => 'shared/layout/mail/base.html.twig',
            ]
        );

        $text = $this->twig->render(
            name: $template,
            context: $data + [
                '_format' => 'text',
                '_layout' => 'shared/layout/mail/base.text.twig',
            ]
        );

        return (new Email())
            ->from(new Address('noreply@devscast.org', 'Devscast Community'))
            ->html($html)
            ->text($text);
    }

    public function send(Email $email): void
    {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }
    }
}
