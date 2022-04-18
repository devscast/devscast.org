<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\RequestLoginLinkCommand;
use Infrastructure\Authentication\Symfony\Form\RequestLoginLinkForm;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class LoginLinkController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/login/link', name: 'authentication_login_link_')]
final class LoginLinkController extends AbstractController
{
    #[Route('/request', name: 'request', methods: ['GET', 'POST'])]
    public function request(Request $request): Response
    {
        if ($this->getUser()) {
            $this->redirectToRoute('app_index');
        }

        $command = new RequestLoginLinkCommand();
        $form = $this->createForm(RequestLoginLinkForm::class, $command)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->dispatchSync($command);
                $this->addFlash('success', $this->translator->trans(
                    id: 'authentication.flashes.login_link_requested_successfully',
                    parameters: [],
                    domain: 'authentication'
                ));

                return $this->redirectSeeOther('authentication_login');
            } catch (AuthenticationException) {
                $this->addFlash('error', $this->translator->trans(
                    id: 'authentication.flashes.something_went_wrong',
                    parameters: [],
                    domain: 'authentication'
                ));
            } catch (\Throwable $e) {
                $this->handleUnexpectedException($e);
            }
        }

        return $this->render(
            view: 'domain/authentication/login_link.html.twig',
            parameters: [
                'form' => $form->createView(),
            ],
            response: $this->getResponseBasedOnFormValidationStatus($form)
        );
    }

    #[Route('/check', name: 'check', methods: ['GET'])]
    public function check(): never
    {
        throw new \LogicException('This code should never be reached');
    }
}
