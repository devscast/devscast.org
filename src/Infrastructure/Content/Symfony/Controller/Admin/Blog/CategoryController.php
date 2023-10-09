<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin\Blog;

use Application\Content\Command\Blog\CreateCategoryCommand;
use Application\Content\Command\Blog\DeleteCategoryCommand;
use Application\Content\Command\Blog\UpdateCategoryCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Blog\Category;
use Infrastructure\Content\Doctrine\Repository\Blog\CategoryRepository;
use Infrastructure\Content\Symfony\Form\Blog\CreateCategoryForm;
use Infrastructure\Content\Symfony\Form\Blog\UpdateCategoryForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class CategoryController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/category', 'admin_content_blog_category_')]
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
        return $this->handleCommand(new CreateCategoryCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreateCategoryForm::class,
            hasIndex: true,
            hasShow: false
        ));
    }

    #[Route('/edit/{id}', name: 'edit', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET', 'POST'])]
    public function edit(Category $item): Response
    {
        return $this->handleCommand(new UpdateCategoryCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdateCategoryForm::class,
            hasIndex: true,
            hasShow: false
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Category $item): Response
    {
        return $this->handleCommand(new DeleteCategoryCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}