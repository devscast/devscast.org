<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Domain\Authentication\ValueObject\Role;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(Role::USER)]
#[Route('/profile/settings/authentication', name: 'authentication_settings_')]
final class SettingController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('domain/authentication/setting.html.twig');
    }
}
