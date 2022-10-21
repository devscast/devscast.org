<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePodcastSeasonCommand;
use Application\Content\Command\DeletePodcastSeasonCommand;
use Application\Content\Command\UpdatePodcastSeasonCommand;
use Domain\Content\Entity\PodcastSeason;
use Infrastructure\Content\Doctrine\Repository\PodcastSeasonRepository;
use Infrastructure\Content\Symfony\Form\CreatePodcastSeasonForm;
use Infrastructure\Content\Symfony\Form\UpdatePodcastSeasonForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PodcastSeasonController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/seasons', 'administration_content_podcast_season_')]
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
        return $this->executeFormCommand(new CreatePodcastSeasonCommand(), CreatePodcastSeasonForm::class);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(PodcastSeason $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdatePodcastSeasonCommand($row),
            formClass: UpdatePodcastSeasonForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(PodcastSeason $row): Response
    {
        return $this->executeDeleteCommand(new DeletePodcastSeasonCommand($row), $row);
    }
}
