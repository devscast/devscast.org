<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTrainingCommand;
use Application\Content\Command\DeleteTrainingCommand;
use Application\Content\Command\UpdateTrainingCommand;
use Domain\Content\Entity\Training;
use Infrastructure\Content\Doctrine\Repository\TrainingRepository;
use Infrastructure\Content\Symfony\Form\CreateTrainingForm;
use Infrastructure\Content\Symfony\Form\UpdateTrainingForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class TrainingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/trainings', 'administration_content_training_')]
final class TrainingController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'training';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(TrainingRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $owner = $this->getUser();

        return $this->executeFormCommand(new CreateTrainingCommand($owner), CreateTrainingForm::class);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Training $row): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $row,
            ]
        );
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Training $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdateTrainingCommand($row),
            formClass: UpdateTrainingForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Training $row): Response
    {
        return $this->executeDeleteCommand(new DeleteTrainingCommand($row), $row);
    }
}
