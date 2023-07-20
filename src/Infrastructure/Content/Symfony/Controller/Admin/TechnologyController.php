<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTechnologyCommand;
use Application\Content\Command\DeleteTechnologyCommand;
use Application\Content\Command\UpdateTechnologyCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Technology;
use Infrastructure\Content\Doctrine\Repository\TechnologyRepository;
use Infrastructure\Content\Symfony\Form\CreateTechnologyForm;
use Infrastructure\Content\Symfony\Form\UpdateTechnologyForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class TechnologyController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/technologies', 'admin_content_technology_')]
final class TechnologyController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'technology';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(TechnologyRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreateTechnologyCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateTechnologyForm::class,
            hasIndex: true,
            hasShow: false
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(Technology $item): Response
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
    public function edit(Technology $item): Response
    {
        return $this->handleCommand(new UpdateTechnologyCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateTechnologyForm::class,
            hasIndex: true,
            hasShow: false
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Technology $item): Response
    {
        return $this->handleCommand(new DeleteTechnologyCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
