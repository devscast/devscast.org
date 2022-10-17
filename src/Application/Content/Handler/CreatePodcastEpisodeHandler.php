<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePodcastEpisodeCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePodcastEpisodeHandler
{
    public function __invoke(CreatePodcastEpisodeCommand $command): void
    {
    }
}
