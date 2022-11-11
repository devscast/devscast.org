<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreateCategoryCommand;
use Application\Content\Command\DeleteCategoryCommand;
use Application\Content\Command\UpdateCategoryCommand;
use Domain\Content\Entity\Category;
use Infrastructure\Content\Doctrine\Repository\CategoryRepository;
use Infrastructure\Content\Symfony\Form\CreateCategoryForm;
use Infrastructure\Content\Symfony\Form\UpdateCategoryForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class CategoryController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/categories', 'administration_content_category_')]
final class CategoryController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'category';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CategoryRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->executeFormCommand(new CreateCategoryCommand(), CreateCategoryForm::class);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Category $row): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $row,
            ]
        );
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Category $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdateCategoryCommand($row),
            formClass: UpdateCategoryForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Category $row): Response
    {
        return $this->executeDeleteCommand(new DeleteCategoryCommand($row), $row);
    }
}
