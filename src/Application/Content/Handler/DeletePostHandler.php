<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeletePostCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePostHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeletePostHandler
{
    public function __invoke(DeletePostCommand $command): void
    {
    }
}
