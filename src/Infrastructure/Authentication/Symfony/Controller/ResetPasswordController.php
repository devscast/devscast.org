<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResetPasswordController
 * @package Infrastructure\Authentication\Symfony\Controller
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/authentication/password', name: 'authentication_reset_password_')]
final class ResetPasswordController extends AbstractController
{
}
