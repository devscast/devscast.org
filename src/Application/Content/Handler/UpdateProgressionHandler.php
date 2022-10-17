<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateProgressionCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateProgressionHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateProgressionHandler
{
    public function __invoke(UpdateProgressionCommand $command): void
    {
    }
}
