<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeletePodcastSeasonCommand;
use Domain\Content\Repository\PodcastSeasonRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeletePodcastSeasonHandler
{
    public function __construct(
        private readonly PodcastSeasonRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeletePodcastSeasonCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
