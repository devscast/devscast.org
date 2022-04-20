<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\Resend2FACodeCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\Exception\RateLimitExceededException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class Login2FaController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Login2FAController extends AbstractController
{
    #[Route('/login/2fa_resend_code', name: 'authentication_2fa_resend_code', methods: ['POST', 'GET'])]
    public function resend(Request $request, Security $security): Response
    {
        try {
            /** @var User|null $user */
            $user = $security->getToken()?->getUser();

            if (null !== $user) {
                $this->dispatchSync(new Resend2FACodeCommand((string) $request->getClientIp(), $user));
                $this->addFlash('error', $this->translator->trans(
                    id: 'authentication.flashes.resend_code_requested_successfully',
                    parameters: [],
                    domain: 'authentication'
                ));
            }
        } catch (RateLimitExceededException $e) {
            $this->addFlash('error', $this->translator->trans(
                id: 'authentication.flashes.too_many_resend_code_request',
                parameters: [],
                domain: 'authentication'
            ));
        } catch (\Throwable $e) {
            $this->handleUnexpectedException($e);
        }

        return $this->redirectSeeOther('app_index');
    }
}
