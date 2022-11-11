<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePodcastSeasonCommand;
use Application\Content\Service\ContentService;
use Application\Shared\Mapper;
use Domain\Content\Entity\PodcastSeason;
use Domain\Content\Repository\PodcastSeasonRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePodcastSeasonHandler
{
    public function __construct(
        private readonly PodcastSeasonRepositoryInterface $repository,
        private readonly ContentService $contentService,
    ) {
    }

    public function __invoke(CreatePodcastSeasonCommand $command): void
    {
        $this->contentService->assertValidSlug($command);
        $this->repository->save(Mapper::getHydratedObject($command, new PodcastSeason()));
    }
}
