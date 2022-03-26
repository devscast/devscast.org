<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class LoginOAuthController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/login/oauth', name: 'authentication_oauth_')]
final class LoginOAuthController extends AbstractController
{
    public const SCOPES = [
        'github' => ['user:email'],
        'google' => [],
    ];

    public function __construct(
        private readonly ClientRegistry $clientRegistry
    ) {
    }

    #[Route('/connect/{service}', name: 'connect', methods: ['GET'])]
    public function connect(string $service): RedirectResponse
    {
        $this->ensureServiceAccepted($service);

        return $this->clientRegistry
            ->getClient($service)
            ->redirect(
                scopes: self::SCOPES[$service],
                options: [
                    'a' => 1,
                ]
            );
    }

    #[Route('/unlink/{service}', name: 'disconnect', methods: ['POST'])]
    public function disconnect(
        string $service,
        EntityManagerInterface $em
    ): RedirectResponse {
        $this->ensureServiceAccepted($service);
        $method = 'set' . ucfirst($service) . 'Id';
        $this->getUser()?->{$method}(null);
        $em->flush();

        $this->addFlash('success', 'Votre compte a bien été dissocié de ' . $service);

        return $this->redirectToRoute('app_index');
    }

    #[Route('/check/{service}', name: 'check', methods: ['GET', 'POST'])]
    public function check(): Response
    {
        return new Response(status: Response::HTTP_OK);
    }

    /**
     * verification de la prise en charge des services oauth supporter par application.
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    private function ensureServiceAccepted(string $service): void
    {
        if (! in_array($service, array_keys(self::SCOPES), true)) {
            throw new AccessDeniedException();
        }
    }
}
