<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteTechnologyCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteTechnologyCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteTechnologyHandler
{
    public function __invoke(DeleteTechnologyCommand $command): void
    {
    }
}
