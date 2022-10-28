<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateTrainingChapterCommand;
use Application\Shared\Mapper;
use Domain\Content\Repository\TrainingChapterRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTrainingChapterHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateTrainingChapterHandler
{
    public function __construct(
        private readonly TrainingChapterRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateTrainingChapterCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->chapter));
    }
}
