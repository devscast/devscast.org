<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateVideoCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateVideoCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateVideoHandler
{
    public function __invoke(UpdateVideoCommand $command): void
    {
    }
}
