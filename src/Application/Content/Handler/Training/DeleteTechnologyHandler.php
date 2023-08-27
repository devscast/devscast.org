<?php

declare(strict_types=1);

namespace Application\Content\Handler\Training;

use Application\Content\Command\Training\DeleteTechnologyCommand;
use Domain\Content\Repository\Training\TechnologyRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteTechnologyCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class DeleteTechnologyHandler
{
    public function __construct(
        private TechnologyRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteTechnologyCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
