<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateRatingCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateRatingHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateRatingHandler
{
    public function __invoke(CreateRatingCommand $command): void
    {
    }
}
