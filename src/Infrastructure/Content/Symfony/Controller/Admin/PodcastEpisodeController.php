<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePodcastEpisodeCommand;
use Application\Content\Command\DeletePodcastEpisodeCommand;
use Application\Content\Command\UpdatePodcastEpisodeCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\PodcastEpisode;
use Infrastructure\Content\Doctrine\Repository\PodcastEpisodeRepository;
use Infrastructure\Content\Symfony\Form\CreatePodcastEpisodeForm;
use Infrastructure\Content\Symfony\Form\UpdatePodcastEpisodeForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class PodcastEpisodeController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/podcasts/episodes', 'admin_content_podcast_episode_')]
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
        return $this->handleCommand(new CreatePodcastEpisodeCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreatePodcastEpisodeForm::class
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(PodcastEpisode $item): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $item,
            ]
        );
    }

    #[Route('/edit/{id}', name: 'edit', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET', 'POST'])]
    public function edit(PodcastEpisode $item): Response
    {
        return $this->handleCommand(new UpdatePodcastEpisodeCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdatePodcastEpisodeForm::class
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(PodcastEpisode $item): Response
    {
        return $this->handleCommand(new DeletePodcastEpisodeCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
