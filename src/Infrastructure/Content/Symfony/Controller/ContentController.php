<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Domain\Content\Entity\Content;
use Domain\Content\Event\ContentViewedEvent;
use Domain\Content\ValueObject\ContentStatus;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class ContentController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class ContentController extends AbstractController
{
    #[Route(
        '/{type<posts|podcasts|videos|trainings>}',
        name: 'content_index',
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

    #[Route(
        '/{type<posts|podcasts|videos|trainings>}/{slug<[a-zA-Z0-9-]+>}-{id<\d+>}',
        name: 'content_show',
        methods: ['GET']
    )]
    public function show(
        EventDispatcherInterface $dispatcher,
        Request $request,
        Content $content,
        string $type,
        string $slug
    ): Response {
        // redirect to updated slug for better SEO
        if ($content->getSlug() !== $slug) {
            return $this->redirectToRoute(
                route: 'content_show',
                parameters: [
                    'type' => sprintf('%ss', $content->getContentType()),
                    'slug' => $content->getSlug(),
                    'id' => $content->getId(),
                ],
                status: Response::HTTP_MOVED_PERMANENTLY
            );
        }

        if (false === $content->getStatus()->equals(ContentStatus::published()) || false === $content->isIsOnline()) {
            throw new AccessDeniedHttpException();
        }

        // if a content is found but does not match with the type requested
        if (! str_starts_with($type, (string) $content->getContentType())) {
            throw new NotFoundHttpException();
        }

        $dispatcher->dispatch(new ContentViewedEvent($content, (string) $request->getClientIp(), $this->getUser()));

        return $this->render(
            view: match ((string) $content->getContentType()) {
                'podcast' => '@app/domain/content/podcast_episode/show.html.twig',
                'video' => '@app/domain/content/video/show.html.twig',
                'training' => '@app/domain/content/training/show.html.twig',
                default => '@app/domain/content/post/show.html.twig',
            },
            parameters: [
                'content' => $content,
            ]
        );
    }
}
