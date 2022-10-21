<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePodcastEpisodeCommand;
use Application\Content\Command\DeletePodcastEpisodeCommand;
use Application\Content\Command\UpdatePodcastEpisodeCommand;
use Domain\Content\Entity\PodcastEpisode;
use Infrastructure\Content\Doctrine\Repository\PodcastEpisodeRepository;
use Infrastructure\Content\Symfony\Form\CreatePodcastEpisodeForm;
use Infrastructure\Content\Symfony\Form\UpdatePodcastEpisodeForm;
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
#[Route('/admin/content/podcast/episodes', 'administration_content_podcast_episode_')]
final class PodcastEpisodeController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'podcast_episode';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PodcastEpisodeRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $owner = $this->getUser();

        return $this->executeFormCommand(new CreatePodcastEpisodeCommand($owner), CreatePodcastEpisodeForm::class);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(PodcastEpisode $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdatePodcastEpisodeCommand($row),
            formClass: UpdatePodcastEpisodeForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(PodcastEpisode $row): Response
    {
        return $this->executeDeleteCommand(new DeletePodcastEpisodeCommand($row), $row);
    }
}
