<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTechnologyCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTechnologyHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateTechnologyHandler
{
    public function __invoke(CreateTechnologyCommand $command): void
    {
    }
}
