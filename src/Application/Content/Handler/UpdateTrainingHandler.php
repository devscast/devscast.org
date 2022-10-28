<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateTrainingCommand;
use Application\Shared\Mapper;
use Domain\Content\Repository\TrainingRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTrainingCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateTrainingHandler
{
    public function __construct(
        private readonly TrainingRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateTrainingCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->training));
    }
}
