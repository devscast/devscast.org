<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\ConfirmRegistrationCommand;
use Application\Authentication\Command\RegisterUserCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\OAuthRegistrationService;
use Infrastructure\Authentication\Symfony\Authenticator\LoginFormAuthenticator;
use Infrastructure\Authentication\Symfony\Form\RegisterUserForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

/**
 * class RegistrationController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/register', name: 'authentication_')]
final class RegistrationController extends AbstractController
{
    #[Route('', name: 'register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        OAuthRegistrationService $OAuthService,
        UserAuthenticatorInterface $authenticator,
        LoginFormAuthenticator $loginFormAuthenticator
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_index');
        }

        $command = new RegisterUserCommand();
        $isOAuth = 1 === $request->query->getInt('oauth') && $OAuthService->hydrate($command);
        $form = $this->createForm(RegisterUserForm::class, $command)
            ->handleRequest($request);

        if ($isOAuth && false === $form->isSubmitted()) {
            $this->addFlash('success', $this->translator->trans(
                id: 'authentication.flashes.complete_username',
                parameters: [],
                domain: 'authentication'
            ));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** @var User $user */
                $user = $this->getHandledResultSync($command);

                if ($isOAuth) {
                    $OAuthService->desist();
                    $this->addFlash('success', $this->translator->trans(
                        id: 'authentication.flashes.user_registered_with_oauth_successfully',
                        parameters: [
                            '%name%' => $command->username,
                            '%service%' => $command->oauth_type,
                        ],
                        domain: 'authentication'
                    ));

                    return $authenticator->authenticateUser($user, $loginFormAuthenticator, $request) ?:
                        $this->redirectSeeOther('app_index');
                }
                $this->addFlash('success', $this->translator->trans(
                    id: 'authentication.flashes.user_registered_with_email_successfully',
                    parameters: [
                        '%name%' => $command->username,
                    ],
                    domain: 'authentication'
                ));

                return $this->redirectSeeOther('authentication_login');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->renderForm(
            view: '@app/domain/authentication/register.html.twig',
            parameters: [
                'form' => $form,
                'is_oauth' => $isOAuth,
            ],
            response: $response ?? null
        );
    }

    #[Route('/confirm/{token}', name: 'register_confirm', methods: ['GET'])]
    public function confirm(string $token): Response
    {
        try {
            $this->dispatchSync(new ConfirmRegistrationCommand($token));
            $this->addFlash('success', $this->translator->trans(
                id: 'authentication.flashes.registration_confirmed_successfully',
                parameters: [],
                domain: 'authentication'
            ));
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther('authentication_login');
    }
}
