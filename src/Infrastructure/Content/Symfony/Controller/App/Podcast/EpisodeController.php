<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\App\Podcast;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Podcast\Episode;
use Domain\Content\Event\ContentViewedEvent;
use Domain\Content\Repository\Podcast\EpisodeRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * Class EpisodeController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/podcasts', name: 'app_content_podcast_episode_')]
final class EpisodeController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(EpisodeRepositoryInterface $repository): Response
    {
        return $this->render(
            view: '@app/domain/content/podcast/episode/index.html.twig',
            parameters: [
                'data' => $this->getPaginator()->paginate(
                    target: $repository->findAll(),
                    page: $this->getCurrentRequest()->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }

    #[Route('/feed.rss', name: 'feed', methods: ['GET'], priority: 20)]
    public function feed(EpisodeRepositoryInterface $repository): Response
    {
        $response = $this->render(
            view: '@app/domain/content/podcast/episode/feed.xml.twig',
            parameters: [
                'data' => $repository->findAll(),
            ]
        );
        $response->headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        return $response;
    }

    #[Route('/{slug}-{id}', name: 'show', requirements: [
        'slug' => Requirement::ASCII_SLUG,
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(
        string $slug,
        Episode $item,
        #[CurrentUser] User $user,
        EventDispatcherInterface $dispatcher
    ): Response {
        if ($item->getSlug() !== $slug) {
            return $this->redirectToRoute(
                route: 'app_content_podcast_episode_show',
                parameters: [
                    'id' => $item->getId(),
                    'slug' => $item->getSlug(),
                ],
                status: Response::HTTP_MOVED_PERMANENTLY
            );
        }

        $dispatcher->dispatch(new ContentViewedEvent($item, (string) $this->getCurrentRequest()->getClientIp(), $user));

        return $this->render(
            view: '@app/domain/content/podcast/episode/show.html.twig',
            parameters: [
                'data' => $item,
            ]
        );
    }

    #[Route('/{episode_number}', name: 'show_alias', requirements: [
        'id' => Requirement::DIGITS,
    ], methods: ['GET'])]
    public function showByEpisodeNumber(Episode $item): Response
    {
        return $this->redirectToRoute(
            route: 'app_content_podcast_episode_show',
            parameters: [
                'id' => $item->getId(),
                'slug' => $item->getSlug(),
            ],
            status: Response::HTTP_PERMANENTLY_REDIRECT
        );
    }
}
