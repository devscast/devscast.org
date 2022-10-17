<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateTrainingCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTrainingCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateTrainingHandler
{
    public function __invoke(UpdateTrainingCommand $command): void
    {
    }
}
