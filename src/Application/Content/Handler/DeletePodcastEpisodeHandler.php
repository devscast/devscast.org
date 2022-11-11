<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeletePodcastEpisodeCommand;
use Domain\Content\Repository\PodcastEpisodeRepositoryInterface;
use Domain\Content\Repository\PodcastSeasonRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeletePodcastEpisodeHandler
{
    public function __construct(
        private readonly PodcastEpisodeRepositoryInterface $repository,
        private readonly PodcastSeasonRepositoryInterface $seasonRepository,
    ) {
    }

    public function __invoke(DeletePodcastEpisodeCommand $command): void
    {
        if ($command->episode->getSeason()) {
            $command->episode->getSeason()->decreaseEpisodeCount();
            $this->seasonRepository->save($command->episode->getSeason());
        }

        $this->repository->delete($command->episode);
    }
}
