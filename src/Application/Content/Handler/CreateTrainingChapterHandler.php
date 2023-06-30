<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTrainingChapterCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\TrainingChapter;
use Domain\Content\Repository\TrainingChapterRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTrainingChapterHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateTrainingChapterHandler
{
    public function __construct(
        private readonly TrainingChapterRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateTrainingChapterCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new TrainingChapter()));
    }
}
