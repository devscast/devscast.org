<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePodcastSeasonCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePodcastSeasonHandler
{
    public function __invoke(CreatePodcastSeasonCommand $command): void
    {
    }
}
