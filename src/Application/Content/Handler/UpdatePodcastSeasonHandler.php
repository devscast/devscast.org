<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePodcastSeasonCommand;
use Application\Shared\Mapper;
use Domain\Content\Repository\PodcastSeasonRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePodcastSeasonHandler
{
    public function __construct(
        private readonly PodcastSeasonRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdatePodcastSeasonCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->season));
    }
}
