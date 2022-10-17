<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateTechnologyCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTechnologyHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateTechnologyHandler
{
    public function __invoke(UpdateTechnologyCommand $command): void
    {
    }
}
