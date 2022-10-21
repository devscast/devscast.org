<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\Entity\Content;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class StreamingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class StreamingController extends AbstractController
{
    #[Route('/streaming/content/{uuid}', name: 'content_streaming', methods: ['GET'])]
    public function __invoke(Content $content): void
    {
    }
}
