<?php

declare(strict_types=1);

namespace Application\Content\Handler\Podcast;

use Application\Content\Command\Podcast\DeleteSeasonCommand;
use Domain\Content\Repository\Podcast\SeasonRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeletePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class DeleteSeasonHandler
{
    public function __construct(
        private SeasonRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteSeasonCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
