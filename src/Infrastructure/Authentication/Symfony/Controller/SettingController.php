<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile/settings/authentication', name: 'authentication_settings_')]
final class SettingController extends AbstractController
{
}
