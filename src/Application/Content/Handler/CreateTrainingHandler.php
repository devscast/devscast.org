<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTrainingCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTrainingHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateTrainingHandler
{
    public function __invoke(CreateTrainingCommand $command): void
    {
    }
}
