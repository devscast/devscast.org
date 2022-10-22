<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeletePostListCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePostListHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeletePostListHandler
{
    public function __invoke(DeletePostListCommand $command): void
    {
    }
}