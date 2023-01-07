<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\Entity\Technology;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class TechnologyController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/technologies', name: 'content_technology_')]
final class TechnologyController extends AbstractController
{
    #[Route('/{slug<[a-zA-Z0-9-]+>}', name: 'show', methods: ['GET'])]
    public function show(Technology $row): void
    {
    }
}
