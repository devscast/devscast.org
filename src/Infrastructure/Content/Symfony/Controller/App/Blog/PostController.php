<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\App\Blog;

use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Blog\Post;
use Domain\Content\Event\ContentViewedEvent;
use Domain\Content\Repository\Blog\PostRepositoryInterface;
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
#[Route('/posts', name: 'app_content_blog_post_')]
final class PostController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PostRepositoryInterface $repository): Response
    {
        return $this->render(
            view: '@app/domain/content/blog/post/index.html.twig',
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
    public function feed(PostRepositoryInterface $repository): Response
    {
        $response = $this->render(
            view: '@app/domain/content/blog/post/feed.xml.twig',
            parameters: [
                'data' => $repository->findBy([], limit: 10),
            ]
        );
        $response->headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        return $response;
    }

    #[Route(path: '/{slug}-{id}', name: 'show', requirements: [
        'slug' => Requirement::ASCII_SLUG,
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(
        string $slug,
        Post $item,
        #[CurrentUser] User $user,
        EventDispatcherInterface $dispatcher
    ): Response {
        if ($item->getSlug() !== $slug) {
            return $this->redirectToRoute(
                route: 'app_content_blog_post_show',
                parameters: [
                    'id' => $item->getId(),
                    'slug' => $item->getSlug(),
                ],
                status: Response::HTTP_MOVED_PERMANENTLY
            );
        }

        $dispatcher->dispatch(new ContentViewedEvent($item, (string) $this->getCurrentRequest()->getClientIp(), $user));

        return $this->render(
            view: '@app/domain/content/blog/post/show.html.twig',
            parameters: [
                'data' => $item,
            ]
        );
    }
}
