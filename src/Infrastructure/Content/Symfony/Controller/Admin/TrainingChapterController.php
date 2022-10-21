<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTrainingChapterCommand;
use Application\Content\Command\DeleteTrainingChapterCommand;
use Application\Content\Command\UpdateTrainingChapterCommand;
use Domain\Content\Entity\TrainingChapter;
use Infrastructure\Content\Doctrine\Repository\TrainingChapterRepository;
use Infrastructure\Content\Symfony\Form\CreateTrainingChapterForm;
use Infrastructure\Content\Symfony\Form\UpdateTrainingChapterForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class TrainingChapterController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/training/chapters', 'administration_content_training_chapter_')]
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
        return $this->executeFormCommand(new CreateTrainingChapterCommand(), CreateTrainingChapterForm::class);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(TrainingChapter $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdateTrainingChapterCommand($row),
            formClass: UpdateTrainingChapterForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(TrainingChapter $row): Response
    {
        return $this->executeDeleteCommand(new DeleteTrainingChapterCommand($row), $row);
    }
}
