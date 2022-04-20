<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Setting;

use Application\Authentication\Command\GenerateGoogleAuthenticatorSecretCommand;
use Application\Authentication\Command\Toggle2FACommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Symfony\Form\Setting\Toggle2FaForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TwoFactorSettingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/profile/authentication/settings/2fa', name: 'authentication_setting_2fa_')]
final class TwoFactorController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request, GoogleAuthenticatorInterface $authenticator): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $user = $this->setupTwoFactorSecrets($user);
        $qrcode = $authenticator->getQRContent($user);

        $command = new Toggle2FACommand($user);
        $form = $this->createForm(Toggle2FaForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addFlash('error', $this->translator->trans(
                    id: 'authentication.flashes.2fa_settings_updated_successfully',
                    parameters: [],
                    domain: 'authentication'
                ));
            } catch (\Throwable $e) {
                $this->handleUnexpectedException($e);
            }
        }

        return $this->render(
            view: 'domain/authentication/setting/2fa.html.twig',
            parameters: [
                'form' => $form->createView(),
                'qrcode_content' => $qrcode,
            ]
        );
    }

    private function setupTwoFactorSecrets(User $user): User
    {
        if (empty($user->getGoogleAuthenticatorSecret())) {
            try {
                $this->dispatchSync(new GenerateGoogleAuthenticatorSecretCommand($user));
            } catch (\Throwable $e) {
                $this->handleUnexpectedException($e);
            }
        }

        return $user;
    }
}
