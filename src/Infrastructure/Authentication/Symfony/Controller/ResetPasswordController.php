<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\ConfirmResetPasswordCommand;
use Application\Authentication\Command\RequestResetPasswordCommand;
use Domain\Authentication\Service\ResetPasswordService;
use Infrastructure\Authentication\Exception\ResetPasswordOngoingException;
use Infrastructure\Authentication\Exception\ResetPasswordTokenExpiredException;
use Infrastructure\Authentication\Exception\UserNotFoundException;
use Infrastructure\Authentication\Symfony\Form\ConfirmResetPasswordForm;
use Infrastructure\Authentication\Symfony\Form\RequestResetPasswordForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ResetPasswordController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/password', name: 'authentication_reset_password_')]
final class ResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

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
                $this->commandBus->dispatch($command);
                $this->addFlash('success', $this->translator->trans(
                    id: 'authentication.flashes.reset_password_requested_successfully',
                    parameters: [],
                    domain: 'authentication'
                ));

                return $this->redirectSeeOther('authentication_login');
            } catch (ResetPasswordOngoingException | UserNotFoundException $e) {
                $this->addFlash('error', $this->translator->trans(
                    id: $e->getMessageKey(),
                    parameters: $e->getMessageData(),
                    domain: 'authentication'
                ));
            }
        }

        return $this->render(
            view: 'domain/authentication/reset_password_request.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
            response: $this->getResponseBasedOnFormValidationStatus($form)
        );
    }

    #[Route('/confirm/{token}', name: 'confirm', methods: ['GET', 'POST'])]
    public function confirm(string $token, ResetPasswordService $service, Request $request): Response
    {
        try {
            $token = $service->findToken($token);
        } catch (ResetPasswordTokenExpiredException) {
            $this->addFlash('error', $this->translator->trans(
                id: 'authentication.exceptions.reset_password_token_expired',
                parameters: [],
                domain: 'authentication'
            ));

            return $this->redirectSeeOther('authentication_login');
        }

        $command = new ConfirmResetPasswordCommand($token);
        $form = $this->createForm(ConfirmResetPasswordForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($command);
            $this->addFlash('success', $this->translator->trans(
                id: 'authentication.flashes.reset_password_confirmed_successfully',
                parameters: [],
                domain: 'authentication'
            ));
            $this->redirectSeeOther('authentication_login');
        }

        return $this->render(
            view: 'domain/authentication/reset_password_confirm.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
            response: $this->getResponseBasedOnFormValidationStatus($form)
        );
    }
}
