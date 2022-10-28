<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePostListCommand;
use Application\Shared\Mapper;
use Domain\Content\Repository\PostListRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePostListHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePostListHandler
{
    public function __construct(
        private readonly PostListRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdatePostListCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->list));
    }
}
