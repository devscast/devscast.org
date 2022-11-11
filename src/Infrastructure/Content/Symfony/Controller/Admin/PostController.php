<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\CreatePostCommand;
use Application\Content\Command\DeletePostCommand;
use Application\Content\Command\UpdatePostCommand;
use Domain\Content\Entity\Post;
use Infrastructure\Content\Doctrine\Repository\PostRepository;
use Infrastructure\Content\Symfony\Form\CreatePostForm;
use Infrastructure\Content\Symfony\Form\UpdatePostForm;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class PostController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/posts', 'administration_content_post_')]
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
        $owner = $this->getUser();

        return $this->executeFormCommand(new CreatePostCommand($owner), CreatePostForm::class);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $row): Response
    {
        return $this->render(
            view: $this->getViewPath('show'),
            parameters: [
                'data' => $row,
            ]
        );
    }

    #[Route('/edit/{id<\d+>}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Post $row): Response
    {
        return $this->executeFormCommand(
            command: new UpdatePostCommand($row),
            formClass: UpdatePostForm::class,
            row: $row,
            view: 'edit'
        );
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Post $row): Response
    {
        return $this->executeDeleteCommand(new DeletePostCommand($row), $row);
    }
}
