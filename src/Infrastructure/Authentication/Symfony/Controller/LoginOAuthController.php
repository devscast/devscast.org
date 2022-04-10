<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\ConnectOAuthServiceCommand;
use Application\Authentication\Command\DisconnectOAuthServiceCommand;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Exception\UnsupportedOAuthServiceException;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class LoginOAuthController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/login/oauth', name: 'authentication_oauth_')]
final class LoginOAuthController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/connect/{service}', name: 'connect', methods: ['GET'])]
    public function connect(string $service): RedirectResponse
    {
        try {
            $envelope = $this->commandBus->dispatch(new ConnectOAuthServiceCommand($service));

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            /** @var RedirectResponse $response */
            $response = $stamp->getResult();

            $this->addFlash('success', $this->translator->trans(
                id: 'authentication.flashes.oauth_service_login_successfully',
                parameters: [
                    '%service%' => $service,
                ],
                domain: 'authentication'
            ));

            return $response;
        } catch (UnsupportedOAuthServiceException) {
            throw new NotFoundHttpException();
        }
    }

    #[Route('/disconnect/{service}', name: 'disconnect', methods: ['POST'])]
    public function disconnect(string $service, #[CurrentUser] User $user): RedirectResponse
    {
        try {
            $this->commandBus->dispatch(new DisconnectOAuthServiceCommand($user, $service));
            $this->addFlash('success', $this->translator->trans(
                id: 'authentication.flashes.oauth_service_disconnected_successfully',
                parameters: [
                    '%service%' => $service,
                ],
                domain: 'authentication'
            ));

            // TODO redirect to profile
            return $this->redirectToRoute('app_index');
        } catch (UnsupportedOAuthServiceException) {
            throw new NotFoundHttpException();
        }
    }

    #[Route('/check/{service}', name: 'check', methods: ['GET', 'POST'])]
    public function check(): Response
    {
        return new Response(status: Response::HTTP_OK);
    }
}
