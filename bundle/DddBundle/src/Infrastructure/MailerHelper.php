<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure;

use Devscast\Bundle\DddBundle\WhiteLabel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\{Address, Email};
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\{LoaderError, RuntimeError, SyntaxError};

/**
 * Class Mailer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MailerHelper
{
    public function __construct(
        private readonly WhiteLabel $whiteLabel,
        private readonly Environment $twig,
        private readonly MailerInterface $mailer,
        private readonly TranslatorInterface $translator,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function createEmail(string $template, array $data = []): Email
    {
        $html = $this->twig->render(
            name: $template,
            context: [
                ...$data,
                '_format' => 'html',
                '_layout' => '@DevscastDashlite/mailing/base.html.twig',
            ]
        );

        $text = $this->twig->render(
            name: $template,
            context: [
                ...$data,
                '_format' => 'text',
                '_layout' => '@DevscastDashlite/mailing/base.text.twig',
            ]
        );

        return (new Email())
            ->from(new Address(
                $this->whiteLabel->application['sender_email'],
                $this->whiteLabel->application['sender_name']
            ))
            ->html($html)
            ->text($text);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendNotificationEmail(
        object $event,
        string $template,
        string $subject,
        array $subject_parameters = [],
        string $domain = 'messages'
    ): void {
        if (! property_exists($event, 'user')) {
            throw new \RuntimeException('Event must have a reference to the user !');
        }

        /** @var UserInterface $user */
        $user = $event->user;

        $this->send(
            $this->createEmail(
                template: $template,
                data: [
                    'user' => $user,
                    'event' => $event,
                ]
            )->subject($this->translator->trans(
                id: $subject,
                parameters: $subject_parameters,
                domain: $domain
            ))->to(new Address($user->getUserIdentifier(), $user->getUserIdentifier()))
        );
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
