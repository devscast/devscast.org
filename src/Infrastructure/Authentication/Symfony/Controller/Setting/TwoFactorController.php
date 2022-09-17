<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Setting;

use Application\Authentication\Command\GenerateGoogleAuthenticatorSecretCommand;
use Application\Authentication\Command\ToggleTwoFactorCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Symfony\Form\Setting\ToggleTwoFactorForm;
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

        $command = new ToggleTwoFactorCommand($user);
        $form = $this->createForm(ToggleTwoFactorForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessFlash(
                    id: 'authentication.flashes.2fa_settings_updated_successfully',
                    domain: 'authentication'
                );
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }
        }

        return $this->renderForm(
            view: '@app/domain/authentication/setting/two_factor.html.twig',
            parameters: [
                'form' => $form,
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
                $this->addSafeMessageExceptionFlash($e);
            }
        }

        return $user;
    }
}
