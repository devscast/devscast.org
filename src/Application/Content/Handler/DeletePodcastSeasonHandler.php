<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeletePodcastSeasonCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeletePodcastSeasonHandler
{
    public function __invoke(DeletePodcastSeasonCommand $command): void
    {
    }
}
