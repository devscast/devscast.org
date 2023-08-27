<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\ConnectOAuthServiceCommand;
use Application\Authentication\Command\DisconnectOAuthServiceCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * Class LoginOAuthController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/login/oauth', name: 'auth_oauth_')]
final class LoginOAuthController extends AbstractController
{
    #[Route('/connect/{service}', name: 'connect', methods: ['GET'])]
    public function connect(string $service): RedirectResponse
    {
        try {
            /** @var RedirectResponse $response */
            $response = $this->getHandledResultSync(new ConnectOAuthServiceCommand($service));

            $this->addSuccessFlash(
                id: 'authentication.flashes.oauth_service_login_successfully',
                parameters: [
                    '%service%' => $service,
                ],
                domain: 'authentication'
            );

            return $response;
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);

            return $this->redirectSeeOther('auth_login');
        }
    }

    #[Route('/disconnect/{service}', name: 'disconnect', methods: ['POST'])]
    public function disconnect(string $service, #[CurrentUser] User $user): RedirectResponse
    {
        try {
            $this->dispatchSync(new DisconnectOAuthServiceCommand($user, $service));
            $this->addSuccessFlash(
                id: 'authentication.flashes.oauth_service_disconnected_successfully',
                parameters: [
                    '%service%' => $service,
                ],
                domain: 'authentication'
            );

            // TODO redirect to profile
            return $this->redirectToRoute('app_index');
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);

            return $this->redirectSeeOther('authentication_settings_index');
        }
    }

    #[Route('/check/{service}', name: 'check', methods: ['GET', 'POST'])]
    public function check(): Response
    {
        return new Response(status: Response::HTTP_OK);
    }
}
