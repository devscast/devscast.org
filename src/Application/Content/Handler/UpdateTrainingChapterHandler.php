<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateTrainingChapterCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTrainingChapterHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateTrainingChapterHandler
{
    public function __invoke(UpdateTrainingChapterCommand $command): void
    {
    }
}
