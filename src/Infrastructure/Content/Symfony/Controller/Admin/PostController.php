<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePostCommand;
use Application\Content\Command\DeletePostCommand;
use Application\Content\Command\UpdatePostCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Content\Entity\Post;
use Infrastructure\Content\Doctrine\Repository\PostRepository;
use Infrastructure\Content\Symfony\Form\CreatePostForm;
use Infrastructure\Content\Symfony\Form\UpdatePostForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/posts', 'admin_content_post_')]
final class PostController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'post';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(PostRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->handleCommand(new CreatePostCommand(), new CrudParams(
            action: CrudAction::CREATE,
            formClass: CreatePostForm::class
        ));
    }

    #[Route('/{id}', name: 'show', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET'])]
    public function show(Post $item): Response
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
    public function edit(Post $item): Response
    {
        return $this->handleCommand(new UpdatePostCommand($item), new CrudParams(
            action: CrudAction::UPDATE,
            item: $item,
            formClass: UpdatePostForm::class,
            hasIndex: true,
            hasShow: true
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Post $item): Response
    {
        return $this->handleCommand(new DeletePostCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
