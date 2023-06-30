<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateCommentCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\CommentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateCommentHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateCommentHandler
{
    public function __construct(
        private readonly CommentRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateCommentCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
