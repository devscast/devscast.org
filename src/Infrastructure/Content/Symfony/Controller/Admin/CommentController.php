<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Admin;

use Application\Content\Command\DeleteCommentCommand;
use Application\Content\Command\ReplyToCommentCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractCrudController;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudAction;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\CrudParams;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Comment;
use Infrastructure\Content\Doctrine\Repository\CommentRepository;
use Infrastructure\Content\Symfony\Form\ReplyToCommentForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * class CommentController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/admin/content/comment', 'admin_content_comment_')]
final class CommentController extends AbstractCrudController
{
    protected const DOMAIN = 'content';
    protected const ENTITY = 'comment';

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CommentRepository $repository): Response
    {
        return $this->queryIndex($repository);
    }

    #[Route('/reply/{id}', name: 'reply', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['GET', 'POST'])]
    public function reply(Comment $item, #[CurrentUser] User $user): Response
    {
        return $this->handleCommand(new ReplyToCommentCommand($user, $item), new CrudParams(
            item: $item,
            formClass: ReplyToCommentForm::class
        ));
    }

    #[Route('/{id}', name: 'delete', requirements: [
        'id' => Requirement::UUID,
    ], methods: ['POST', 'DELETE'])]
    public function delete(Comment $item): Response
    {
        return $this->handleCommand(new DeleteCommentCommand($item), new CrudParams(
            action: CrudAction::DELETE,
            item: $item
        ));
    }
}
