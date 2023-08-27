<?php

declare(strict_types=1);

namespace Application\Content\Handler\Podcast;

use Application\Content\Command\Podcast\DeleteEpisodeCommand;
use Domain\Content\Repository\Podcast\EpisodeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class DeleteEpisodeHandler
{
    public function __construct(
        private EpisodeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(DeleteEpisodeCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
