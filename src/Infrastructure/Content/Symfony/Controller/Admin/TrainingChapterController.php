<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTrainingChapterCommand;
use Application\Content\Command\DeleteTrainingChapterCommand;
use Application\Content\Command\UpdateTrainingChapterCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\TrainingChapter;
use Infrastructure\Content\Doctrine\Repository\TrainingChapterRepository;
use Infrastructure\Content\Symfony\Form\CreateTrainingChapterForm;
use Infrastructure\Content\Symfony\Form\UpdateTrainingChapterForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class TrainingChapterController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/trainings/chapters', 'admin_content_training_chapter_')]
final class TrainingChapterController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'training_chapter';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(TrainingChapterRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreateTrainingChapterCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateTrainingChapterForm::class
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(TrainingChapter $item): Response
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
    public function edit(TrainingChapter $item): Response
    {
        return $this->handleCommand(new UpdateTrainingChapterCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateTrainingChapterForm::class
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(TrainingChapter $item): Response
    {
        return $this->handleCommand(new DeleteTrainingChapterCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
