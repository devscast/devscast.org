<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePostListCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\PostList;
use Domain\Content\Repository\PostListRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePostListHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePostListHandler
{
    public function __construct(
        private readonly PostListRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreatePostListCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new PostList()));
    }
}
