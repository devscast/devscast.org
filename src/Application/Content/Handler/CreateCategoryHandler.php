<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateCategoryCommand;
use Application\Shared\Mapper;
use Domain\Content\Entity\Category;
use Domain\Content\Repository\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateCategoryHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateCategoryHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new Category()));
    }
}
