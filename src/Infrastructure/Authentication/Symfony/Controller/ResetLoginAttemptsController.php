<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Application\Authentication\Command\ResetLoginAttemptsCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class ResetLoginAttemptsController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/login/unlock/{token}', name: 'auth_login_attempts_reset', methods: ['GET'])]
final class ResetLoginAttemptsController extends AbstractController
{
    public function __invoke(string $token): Response
    {
        try {
            $this->dispatchSync(new ResetLoginAttemptsCommand($token));
            $this->addSuccessFlash(
                id: 'authentication.flashes.login_attempts_reset_successfully',
                domain: 'authentication'
            );
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther('auth_login');
    }
}
