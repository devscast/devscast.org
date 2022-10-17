<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePostListCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePostListHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePostListHandler
{
    public function __invoke(UpdatePostListCommand $command): void
    {
    }
}
