<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Api;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Content\Entity\Content;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class RatingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class RatingController extends AbstractController
{
    #[Route('/api/content/rating/{id}', name: 'api_content_rating', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST'])]
    public function __invoke(Content $content): void
    {
    }
}
