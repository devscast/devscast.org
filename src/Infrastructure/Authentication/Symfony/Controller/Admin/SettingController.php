<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Admin;

use Application\Authentication\Command\GenerateBackupCodeCommand;
use Application\Authentication\Command\GenerateGoogleAuthenticatorSecretCommand;
use Application\Authentication\Command\ToggleTwoFactorCommand;
use Application\Authentication\Command\UpdatePasswordCommand;
use Application\Authentication\Command\UpdateUserCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Symfony\Form\Setting\ToggleTwoFactorForm;
use Infrastructure\Authentication\Symfony\Form\Setting\UpdatePasswordForm;
use Infrastructure\Authentication\Symfony\Form\UpdateUserForm;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class SettingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[Route('admin/settings', name: 'authentication_setting_')]
final class SettingController extends AbstractController
{
    #[Route('/profile', name: 'profile', methods: ['GET', 'POST'])]
    public function profile(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $command = new UpdateUserCommand($user);
        $form = $this->createForm(UpdateUserForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessFlash(
                    id: 'authentication.flashes.profile_updated_successfully',
                    domain: 'authentication'
                );

                return $this->redirectSeeOther('authentication_setting_profile');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->renderForm(
            view: '@admin/domain/authentication/setting/profile.html.twig',
            parameters: [
                'form' => $form,
            ],
            response: $response ?? null
        );
    }

    #[Route('/security', name: 'security', methods: ['GET', 'POST'])]
    public function security(): Response
    {
        return $this->render('@admin/domain/authentication/setting/security.html.twig');
    }

    #[Route('/security/password', name: 'security_password', methods: ['GET', 'POST'])]
    public function password(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $command = new UpdatePasswordCommand($user);
        $form = $this->createForm(UpdatePasswordForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessFlash(
                    id: 'authentication.flashes.reset_password_confirmed_successfully',
                    domain: 'authentication'
                );

                return $this->redirectSeeOther('authentication_setting_security');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->renderForm(
            view: '@admin/domain/authentication/setting/password.html.twig',
            parameters: [
                'form' => $form,
            ],
            response: $response ?? null
        );
    }

    #[Route('/security/2fa', name: 'security_2fa', methods: ['GET', 'POST'])]
    public function twoFactorAuthentication(GoogleAuthenticatorInterface $authenticator, Request $request): Response
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

        if (empty($user->getBackupCodes())) {
            try {
                $this->dispatchSync(new GenerateBackupCodeCommand($user));
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }
        }

        $command = new ToggleTwoFactorCommand(
            user: $user,
            google: $user->isGoogleAuthenticatorEnabled(),
            email: $user->isEmailAuthEnabled()
        );

        $form = $this->createForm(ToggleTwoFactorForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addFlash('success', 'Paramètres 2FA modifiés');

                return $this->redirectSeeOther('authentication_setting_security_2fa');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $qrcode = $authenticator->getQRContent($user);

        return $this->renderForm(
            view: '@admin/domain/authentication/setting/two_factor.html.twig',
            parameters: [
                'qrcode_content' => $qrcode,
                'form' => $form,
            ],
            response: $response ?? null
        );
    }
}
