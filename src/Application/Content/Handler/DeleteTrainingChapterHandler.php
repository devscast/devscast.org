<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteTrainingChapterCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteTrainingChapterHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteTrainingChapterHandler
{
    public function __invoke(DeleteTrainingChapterCommand $command): void
    {
    }
}
