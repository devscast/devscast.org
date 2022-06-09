<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RequestLoginLinkCommand;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Exception\UserNotFoundException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Shared\Symfony\Mailer\Mailer;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Http\LoginLink\LoginLinkDetails;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class RequestLoginLinkHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class RequestLoginLinkHandler
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly LoginLinkHandlerInterface $loginLinkHandler,
        private readonly TranslatorInterface $translator,
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(RequestLoginLinkCommand $command): void
    {
        $user = $this->repository->findOneByEmail((string) $command->email);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        $loginLinkDetails = $this->loginLinkHandler->createLoginLink($user);
        $this->sendLoginLinkEmail($loginLinkDetails, $user);
    }

    private function sendLoginLinkEmail(LoginLinkDetails $loginLinkDetails, User $user): void
    {
        $email = $this->mailer
            ->createEmail(
                template: 'domain/authentication/mail/login_link.mail.twig',
                data: [
                    'link' => $loginLinkDetails,
                    'user' => $user,
                ]
            )->subject($this->translator->trans(
                id: 'authentication.mails.subjects.login_link_requested',
                parameters: [
                    '%name%' => $user->getUsername(),
                ],
                domain: 'authentication'
            ))
            ->to(new Address((string) $user->getEmail(), (string) $user->getUsername()));

        $this->mailer->send($email);
    }
}
