<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Infrastructure\Content\Doctrine\Repository\PodcastEpisodeRepository;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PodcastEpisodeController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/podcasts/episodes', 'administration_content_podcast_episode_')]
final class PodcastEpisodeController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'podcast_episode';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PodcastEpisodeRepository $repository): Response
    {
        return $this->render(
            view: $this->getViewPath('index'),
            parameters: [
                'data' => $this->paginator->paginate(
                    target: $repository->findBy([], orderBy: [
                        'created_at' => 'DESC',
                    ]),
                    page: $this->request->query->getInt('page', 1),
                    limit: 50
                ),
            ]
        );
    }
}
