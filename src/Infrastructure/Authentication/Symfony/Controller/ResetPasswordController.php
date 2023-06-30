<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\ConfirmResetPasswordCommand;
use Application\Authentication\Command\RequestResetPasswordCommand;
use Application\Authentication\Service\ResetPasswordService;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Exception\ResetPasswordTokenExpiredException;
use Infrastructure\Authentication\Symfony\Form\ConfirmResetPasswordForm;
use Infrastructure\Authentication\Symfony\Form\RequestResetPasswordForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResetPasswordController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/password', name: 'authentication_reset_password_')]
final class ResetPasswordController extends AbstractController
{
    #[Route('/request', name: 'request', methods: ['GET', 'POST'])]
    public function request(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_index');
        }

        $command = new RequestResetPasswordCommand();
        $form = $this->createForm(RequestResetPasswordForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessFlash(
                    id: 'authentication.flashes.reset_password_requested_successfully',
                    domain: 'authentication'
                );
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }

            return $this->redirectSeeOther('authentication_login');
        }

        return $this->render(
            view: '@app/domain/authentication/reset_password_request.html.twig',
            parameters: [
                'form' => $form,
            ],
        );
    }

    #[Route('/confirm/{token}', name: 'confirm', methods: ['GET', 'POST'])]
    public function confirm(string $token, ResetPasswordService $service, Request $request): Response
    {
        try {
            $token = $service->findToken($token);
        } catch (ResetPasswordTokenExpiredException $e) {
            $this->addSafeMessageExceptionFlash($e);

            return $this->redirectSeeOther('authentication_login');
        }

        $command = new ConfirmResetPasswordCommand($token);
        $form = $this->createForm(ConfirmResetPasswordForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addSuccessFlash(
                    id: 'authentication.flashes.reset_password_confirmed_successfully',
                    domain: 'authentication'
                );
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }

            return $this->redirectSeeOther('authentication_login');
        }

        return $this->render(
            view: '@app/domain/authentication/reset_password_confirm.html.twig',
            parameters: [
                'form' => $form,
            ],
        );
    }
}
