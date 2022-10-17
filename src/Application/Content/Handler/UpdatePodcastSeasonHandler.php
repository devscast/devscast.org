<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePodcastSeasonCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePodcastSeasonHandler
{
    public function __invoke(UpdatePodcastSeasonCommand $command): void
    {
    }
}
