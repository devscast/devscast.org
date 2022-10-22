<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTrainingChapterCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTrainingChapterHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateTrainingChapterHandler
{
    public function __invoke(CreateTrainingChapterCommand $command): void
    {
    }
}