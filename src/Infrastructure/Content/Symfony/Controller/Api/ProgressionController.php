<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Api;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\Content;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class ProgressionController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class ProgressionController extends AbstractController
{
    #[Route('/api/content/progression/{id}', name: 'api_content_progression', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST'])]
    public function __invoke(Content $content): void
    {
    }
}
