<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteTrainingCommand;
use Domain\Content\Repository\TrainingRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteTrainingHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteTrainingHandler
{
    public function __construct(
        private readonly TrainingRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteTrainingCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
