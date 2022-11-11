<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class DashboardController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/admin/content', name: 'administration_content_dashboard_')]
final class DashboardController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(
            view: 'admin/domain/content/dashboard/index.html.twig',
            parameters: []
        );
    }
}
