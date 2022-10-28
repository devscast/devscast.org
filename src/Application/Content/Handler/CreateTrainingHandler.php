<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTrainingCommand;
use Application\Shared\Mapper;
use Domain\Content\Entity\Training;
use Domain\Content\Repository\TrainingRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTrainingHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateTrainingHandler
{
    public function __construct(
        private readonly TrainingRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateTrainingCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new Training()));
    }
}
