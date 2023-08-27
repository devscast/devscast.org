<?php

declare(strict_types=1);

namespace Application\Content\Handler\Blog;

use Application\Content\Command\Blog\UpdateCategoryCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\Blog\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateCategoryHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class UpdateCategoryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
