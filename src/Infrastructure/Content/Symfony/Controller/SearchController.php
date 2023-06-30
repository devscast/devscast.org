<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class SearchController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/search', name: 'content_search')]
final class SearchController extends AbstractController
{
    #[Route(
        '',
        name: 'index',
        options: [
            'sitemap' => [
                'priority' => 0.9,
                'changefreg' => 'daily',
            ],
        ],
        methods: ['GET'],
        priority: 12
    )]
    public function __invoke(Request $request): void
    {
    }
}
