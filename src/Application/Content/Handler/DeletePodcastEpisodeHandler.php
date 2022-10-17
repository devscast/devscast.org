<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeletePodcastEpisodeCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeletePodcastEpisodeHandler
{
    public function __invoke(DeletePodcastEpisodeCommand $command): void
    {
    }
}
