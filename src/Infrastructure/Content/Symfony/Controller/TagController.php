<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\Entity\Tag;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class VideoController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/tags<[a-zA-Z0-9-]+>', name: 'content_tag_')]
final class TagController extends AbstractController
{
    #[Route(
        '',
        name: 'index',
        options: [
            'sitemap' => [
                'priority' => 0.6,
                'changefreg' => 'daily',
            ],
        ],
        methods: ['GET']
    )]
    public function index(): void
    {
    }

    #[Route(path: '/{name<[a-zA-Z0-9-]+>}', name: 'show', methods: ['GET'])]
    public function show(Tag $row): void
    {
    }
}
