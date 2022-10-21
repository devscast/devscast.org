<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteVideoCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteVideoHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteVideoHandler
{
    public function __invoke(DeleteVideoCommand $command): void
    {
    }
}
