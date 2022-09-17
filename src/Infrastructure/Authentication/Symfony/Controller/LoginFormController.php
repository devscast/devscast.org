<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\LoginCommand;
use Infrastructure\Authentication\Symfony\Form\LoginForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginFormController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('', name: 'authentication_')]
final class LoginFormController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $command = new LoginCommand();

        if (null !== $error) {
            $command->identifier = $utils->getLastUsername();
            $this->addErrorFlash($error->getMessageKey(), $error->getMessageData());
        }

        $form = $this->createForm(LoginForm::class, $command);

        return $this->renderForm(
            view: '@app/domain/authentication/login.html.twig',
            parameters: [
                'form' => $form,
            ]
        );
    }

    #[Route('/logout', name: 'logout', methods: ['POST', 'GET'])]
    public function logout(): never
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
