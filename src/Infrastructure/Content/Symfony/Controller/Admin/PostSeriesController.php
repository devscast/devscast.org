<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePostSeriesCommand;
use Application\Content\Command\DeletePostSeriesCommand;
use Application\Content\Command\UpdatePostSeriesCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\PostSeries;
use Infrastructure\Content\Doctrine\Repository\PostSeriesRepository;
use Infrastructure\Content\Symfony\Form\CreatePostSeriesForm;
use Infrastructure\Content\Symfony\Form\UpdatePostSeriesForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class PostSeriesController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/posts/series', 'admin_content_post_series_')]
final class PostSeriesController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'post_series';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PostSeriesRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreatePostSeriesCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreatePostSeriesForm::class
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(PostSeries $item): Response
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
    public function edit(PostSeries $item): Response
    {
        return $this->handleCommand(new UpdatePostSeriesCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdatePostSeriesForm::class
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(PostSeries $item): Response
    {
        return $this->handleCommand(new DeletePostSeriesCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
