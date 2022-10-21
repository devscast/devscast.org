<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\DeleteCommentCommand;
use Domain\Content\Entity\Comment;
use Infrastructure\Content\Doctrine\Repository\CommentRepository;
use Infrastructure\Shared\Symfony\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class CommentController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/comments', 'administration_content_comment_')]
final class CommentController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'comment';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CommentRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['POST', 'DELETE'])]
    public function delete(Comment $row): Response
    {
        return $this->executeDeleteCommand(new DeleteCommentCommand($row), $row);
    }
}
