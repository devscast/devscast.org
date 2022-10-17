<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePostCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePostHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePostHandler
{
    public function __invoke(UpdatePostCommand $command): void
    {
    }
}
