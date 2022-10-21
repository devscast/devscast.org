<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Api;

use Domain\Content\Entity\Content;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class ProgressionController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class ProgressionController extends AbstractController
{
    #[Route('/api/content/progression/{id}', name: 'api_content_progression', methods: ['POST'])]
    public function __invoke(Content $content): void
    {
    }
}
