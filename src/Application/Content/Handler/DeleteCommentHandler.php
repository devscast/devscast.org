<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteCommentCommand;
use Domain\Content\Repository\CommentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteCommentHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteCommentHandler
{
    public function __construct(
        private readonly CommentRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteCommentCommand $command): void
    {
        $this->repository->delete($command->comment);
    }
}
