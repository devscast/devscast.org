<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePodcastSeasonCommand;
use Application\Content\Command\DeletePodcastSeasonCommand;
use Application\Content\Command\UpdatePodcastSeasonCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\PodcastSeason;
use Infrastructure\Content\Doctrine\Repository\PodcastSeasonRepository;
use Infrastructure\Content\Symfony\Form\CreatePodcastSeasonForm;
use Infrastructure\Content\Symfony\Form\UpdatePodcastSeasonForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class PodcastSeasonController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/podcasts/seasons', 'admin_content_podcast_season_')]
final class PodcastSeasonController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'podcast_season';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PodcastSeasonRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreatePodcastSeasonCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreatePodcastSeasonForm::class
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(PodcastSeason $item): Response
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
    public function edit(PodcastSeason $item): Response
    {
        return $this->handleCommand(new UpdatePodcastSeasonCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdatePodcastSeasonForm::class
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(PodcastSeason $item): Response
    {
        return $this->handleCommand(new DeletePodcastSeasonCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
