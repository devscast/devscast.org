<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePodcastEpisodeCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePodcastEpisodeHandler
{
    public function __invoke(UpdatePodcastEpisodeCommand $command): void
    {
    }
}
