<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePostListCommand;
use Application\Content\Command\DeletePostListCommand;
use Application\Content\Command\UpdatePostListCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\PostList;
use Infrastructure\Content\Doctrine\Repository\PostListRepository;
use Infrastructure\Content\Symfony\Form\CreatePostListForm;
use Infrastructure\Content\Symfony\Form\UpdatePostListForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class PostListController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/posts/lists', 'admin_content_post_list_')]
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
        return $this->handleCommand(new CreatePostListCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreatePostListForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(PostList $item): Response
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
    public function edit(PostList $item): Response
    {
        return $this->handleCommand(new UpdatePostListCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdatePostListForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(PostList $item): Response
    {
        return $this->handleCommand(new DeletePostListCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
