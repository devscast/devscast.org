<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteCategoryCommand;
use Domain\Content\Repository\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteCategoryCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteCategoryHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
