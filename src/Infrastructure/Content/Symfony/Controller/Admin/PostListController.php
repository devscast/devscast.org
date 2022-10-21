<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePostListCommand;
use Application\Content\Command\DeletePostListCommand;
use Application\Content\Command\UpdatePostListCommand;
use Domain\Content\Entity\PostList;
use Infrastructure\Content\Doctrine\Repository\PostListRepository;
use Infrastructure\Content\Symfony\Form\CreatePostListForm;
use Infrastructure\Content\Symfony\Form\UpdatePostListForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostListController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/post/lists', 'administration_content_post_list_')]
final class PostListController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'post_list';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PostListRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $owner = $this->getUser();

        return $this->executeFormCommand(new CreatePostListCommand($owner), CreatePostListForm::class);
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(PostList $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdatePostListCommand($row),
            formClass: UpdatePostListForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(PostList $row): Response
    {
        return $this->executeDeleteCommand(new DeletePostListCommand($row), $row);
    }
}
