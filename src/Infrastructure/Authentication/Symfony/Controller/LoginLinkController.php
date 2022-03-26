<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginLinkController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/login/link', name: 'authentication_login_link_')]
final class LoginLinkController extends AbstractController
{
    #[Route('/check', name: 'check', methods: ['GET'])]
    public function check(): void
    {
        throw new \LogicException('This code should never be reached');
    }
}
