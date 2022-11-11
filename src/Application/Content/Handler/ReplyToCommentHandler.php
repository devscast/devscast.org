<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\ReplyToCommentCommand;
use Application\Shared\Mapper;
use Domain\Content\Entity\Comment;
use Domain\Content\Repository\CommentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class ReplyToCommentHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ReplyToCommentHandler
{
    public function __construct(
        private readonly CommentRepositoryInterface $repository
    ) {
    }

    public function __invoke(ReplyToCommentCommand $command): void
    {
        // one level comment reply
        if (null !== $command->parent->getParent()) {
            $command->parent = $command->parent->getParent();
        }

        /** @var Comment $comment */
        $comment = Mapper::getHydratedObject($command, new Comment());
        $comment->setTarget($command->parent->getTarget());
        $this->repository->save($comment);
    }
}
