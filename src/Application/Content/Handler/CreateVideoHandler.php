<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateVideoCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateVideoHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateVideoHandler
{
    public function __invoke(CreateVideoCommand $command): void
    {
    }
}
