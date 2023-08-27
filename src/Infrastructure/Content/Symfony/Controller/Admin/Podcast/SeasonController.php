<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin\Podcast;

use Application\Content\Command\Podcast\CreateSeasonCommand;
use Application\Content\Command\Podcast\DeleteSeasonCommand;
use Application\Content\Command\Podcast\UpdateSeasonCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Podcast\Season;
use Infrastructure\Content\Doctrine\Repository\Podcast\SeasonRepository;
use Infrastructure\Content\Symfony\Form\Podcast\CreateSeasonForm;
use Infrastructure\Content\Symfony\Form\Podcast\UpdateSeasonForm;
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
final class SeasonController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'season';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(SeasonRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreateSeasonCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateSeasonForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(Season $item): Response
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
    public function edit(Season $item): Response
    {
        return $this->handleCommand(new UpdateSeasonCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateSeasonForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Season $item): Response
    {
        return $this->handleCommand(new DeleteSeasonCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
