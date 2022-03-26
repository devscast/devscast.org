<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginFormController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('', name: 'authentication_')]
final class LoginFormController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
