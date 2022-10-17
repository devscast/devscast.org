<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateRatingCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateRatingCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateRatingHandler
{
    public function __invoke(UpdateRatingCommand $command): void
    {
    }
}
