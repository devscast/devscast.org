<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateTagCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTagHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateTagHandler
{
    public function __invoke(UpdateTagCommand $command): void
    {
    }
}
