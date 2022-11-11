<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller\Admin;

use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class MainController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/admin', name: 'administration_')]
final class MainController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render(
            view: 'admin/index.html.twig',
            parameters: []
        );
    }
}
