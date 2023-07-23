<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;
use Domain\Content\Event\ContentViewedEvent;
use Domain\Content\ValueObject\ContentStatus;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * class ContentController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
final class ContentController extends AbstractController
{
    #[Route(
        '/{content_type<posts|podcasts|videos|trainings>}',
        name: 'app_content_index',
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
        '/{content_type<posts|podcasts|videos|trainings>}/{id}',
        name: 'app_content_show',
        requirements: [
            'id' => Requirement::UUID,
        ],
        methods: ['GET']
    )]
    public function show(
        #[CurrentUser] User $user,
        EventDispatcherInterface $dispatcher,
        Request $request,
        Content $content,
        string $content_type,
        string $slug
    ): Response {
        if (false === $content->getStatus()->equals(ContentStatus::published()) || false === $content->isIsOnline()) {
            throw new AccessDeniedHttpException();
        }

        // if a content is found but does not match with the type requested
        if (! str_starts_with($content_type, (string) $content->getContentType())) {
            throw new NotFoundHttpException();
        }

        $dispatcher->dispatch(new ContentViewedEvent($content, (string) $request->getClientIp(), $user));

        return $this->render(
            view: match ((string) $content->getContentType()) {
                'podcasts' => '@app/domain/content/podcast_episode/show.html.twig',
                'videos' => '@app/domain/content/video/show.html.twig',
                'trainings' => '@app/domain/content/training/show.html.twig',
                default => '@app/domain/content/post/show.html.twig',
            },
            parameters: [
                'content' => $content,
            ]
        );
    }
}
