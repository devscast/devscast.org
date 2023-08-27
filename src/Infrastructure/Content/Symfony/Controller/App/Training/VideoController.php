<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\App\Training;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Training\Video;
use Domain\Content\Event\ContentViewedEvent;
use Domain\Content\Repository\Training\VideoRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/videos', name: 'app_content_training_video_')]
final class VideoController extends AbstractController
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
    public function index(VideoRepositoryInterface $repository): Response
    {
        return $this->render(
            view: '@app/domain/content/training/video/index.html.twig',
            parameters: [
                'data' => $this->getPaginator()->paginate(
                    target: $repository->findAll(),
                    page: $this->getCurrentRequest()->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }

    #[Route(path: '/{slug}-{id}', name: 'show', requirements: [
        'slug' => Requirement::ASCII_SLUG,
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(
        string $slug,
        Video $item,
        #[CurrentUser] User $user,
        EventDispatcherInterface $dispatcher
    ): Response {
        if ($item->getSlug() !== $slug) {
            return $this->redirectToRoute(
                route: 'app_content_training_video_show',
                parameters: [
                    'id' => $item->getId(),
                    'slug' => $item->getSlug(),
                ],
                status: Response::HTTP_MOVED_PERMANENTLY
            );
        }

        $dispatcher->dispatch(new ContentViewedEvent($item, (string) $this->getCurrentRequest()->getClientIp(), $user));

        return $this->render(
            view: '@app/domain/content/training/video/show.html.twig',
            parameters: [
                'data' => $item,
            ]
        );
    }
}
