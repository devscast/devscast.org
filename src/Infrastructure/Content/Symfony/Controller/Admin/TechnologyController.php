<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateTechnologyCommand;
use Application\Content\Command\DeleteTechnologyCommand;
use Application\Content\Command\UpdateTechnologyCommand;
use Domain\Content\Entity\Technology;
use Infrastructure\Content\Doctrine\Repository\TechnologyRepository;
use Infrastructure\Content\Symfony\Form\CreateTechnologyForm;
use Infrastructure\Content\Symfony\Form\UpdateTechnologyForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class TechnologyController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/technologies', 'administration_content_technology_')]
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
        return $this->executeFormCommand(new CreateTechnologyCommand(), CreateTechnologyForm::class);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Technology $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdateTechnologyCommand($row),
            formClass: UpdateTechnologyForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Technology $row): Response
    {
        return $this->executeDeleteCommand(new DeleteTechnologyCommand($row), $row);
    }
}
