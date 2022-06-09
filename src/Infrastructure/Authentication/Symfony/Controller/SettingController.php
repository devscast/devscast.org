<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\GenerateGoogleAuthenticatorSecretCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
#[Route('/profile/settings/authentication', name: 'authentication_settings_')]
final class SettingController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('domain/authentication/setting/index.html.twig');
    }

    #[Route('/2fa', name: '2fa', methods: ['GET', 'POST'])]
    public function twoFactorAuthentication(GoogleAuthenticatorInterface $authenticator): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (empty($user->getGoogleAuthenticatorSecret())) {
            try {
                $this->dispatchSync(new GenerateGoogleAuthenticatorSecretCommand($user));
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }
        }

        $qrcode = $authenticator->getQRContent($user);

        return $this->render(
            view: 'domain/authentication/setting/2fa.html.twig',
            parameters: [
                'qrcode_content' => $qrcode,
            ]
        );
    }
}
