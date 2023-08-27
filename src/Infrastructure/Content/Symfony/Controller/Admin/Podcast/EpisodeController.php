<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin\Podcast;

use Application\Content\Command\Podcast\CreateEpisodeCommand;
use Application\Content\Command\Podcast\DeleteEpisodeCommand;
use Application\Content\Command\Podcast\UpdateEpisodeCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Podcast\Episode;
use Infrastructure\Content\Doctrine\Repository\Podcast\EpisodeRepository;
use Infrastructure\Content\Symfony\Form\Podcast\CreateEpisodeForm;
use Infrastructure\Content\Symfony\Form\Podcast\UpdateEpisodeForm;
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
final class EpisodeController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'episode';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(EpisodeRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreateEpisodeCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateEpisodeForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(Episode $item): Response
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
    public function edit(Episode $item): Response
    {
        return $this->handleCommand(new UpdateEpisodeCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateEpisodeForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Episode $item): Response
    {
        return $this->handleCommand(new DeleteEpisodeCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
