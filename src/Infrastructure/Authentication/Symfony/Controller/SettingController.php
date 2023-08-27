<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[IsGranted('ROLE_USER')]
#[Route('/profile/settings/authentication', name: 'authentication_setting_')]
final class SettingController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('@app/domain/authentication/setting/index.html.twig');
    }
}
