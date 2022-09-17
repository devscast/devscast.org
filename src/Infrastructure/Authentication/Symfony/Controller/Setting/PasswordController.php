<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Setting;

use Application\Authentication\Command\UpdatePasswordCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Authentication\Symfony\Form\Setting\UpdatePasswordForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PasswordController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/profile/authentication/settings/password', name: 'authentication_setting_password_')]
final class PasswordController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
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

                return $this->redirectSeeOther('authentication_setting_index');
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
                $response = new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->renderForm(
            view: '@app/domain/authentication/setting/password.html.twig',
            parameters: [
                'form' => $form,
            ],
            response: $response ?? null
        );
    }
}
