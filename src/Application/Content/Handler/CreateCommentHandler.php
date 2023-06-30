<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateCommentCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Comment;
use Domain\Content\Repository\CommentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateCommentCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateCommentHandler
{
    public function __construct(
        private readonly CommentRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateCommentCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new Comment()));
    }
}
