<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePostSeriesCommand;
use Application\Content\Command\DeletePostSeriesCommand;
use Application\Content\Command\UpdatePostSeriesCommand;
use Domain\Content\Entity\PostSeries;
use Infrastructure\Content\Doctrine\Repository\PostSeriesRepository;
use Infrastructure\Content\Symfony\Form\CreatePostSeriesForm;
use Infrastructure\Content\Symfony\Form\UpdatePostSeriesForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostSeriesController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/post/series', 'administration_content_post_series_')]
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
        $owner = $this->getUser();

        return $this->executeFormCommand(new CreatePostSeriesCommand($owner), CreatePostSeriesForm::class);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(PostSeries $row): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $row
            ]
        );
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(PostSeries $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdatePostSeriesCommand($row),
            formClass: UpdatePostSeriesForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(PostSeries $row): Response
    {
        return $this->executeDeleteCommand(new DeletePostSeriesCommand($row), $row);
    }
}
