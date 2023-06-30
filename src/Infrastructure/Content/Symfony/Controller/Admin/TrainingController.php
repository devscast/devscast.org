<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTrainingCommand;
use Application\Content\Command\DeleteTrainingCommand;
use Application\Content\Command\UpdateTrainingCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Training;
use Infrastructure\Content\Doctrine\Repository\TrainingRepository;
use Infrastructure\Content\Symfony\Form\CreateTrainingForm;
use Infrastructure\Content\Symfony\Form\UpdateTrainingForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class TrainingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/trainings', 'admin_content_training_')]
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
        return $this->handleCommand(new CreateTrainingCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateTrainingForm::class
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(Training $item): Response
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
    public function edit(Training $item): Response
    {
        return $this->handleCommand(new UpdateTrainingCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateTrainingForm::class
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Training $item): Response
    {
        return $this->handleCommand(new DeleteTrainingCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
