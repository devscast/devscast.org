<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePodcastEpisodeCommand;
use Application\Content\Service\ContentService;
use Application\Shared\Mapper;
use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Repository\ContentRepositoryInterface;
use Domain\Content\ValueObject\ContentStatus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePodcastEpisodeHandler
{
    public function __construct(
        private readonly ContentRepositoryInterface $repository,
        private readonly ContentService $contentService
    ) {
    }

    public function __invoke(CreatePodcastEpisodeCommand $command): void
    {
        $this->contentService->assertScheduleDateInFuture($command);
        $this->contentService->assertValidSlug($command);

        if (true === $command->is_top_promoted && $command->status->equals(ContentStatus::published())) {
            $this->repository->resetTopPromotedContent(PodcastEpisode::class);
        }

        /** @var PodcastEpisode $podcast */
        $podcast = Mapper::getHydratedObject($command, new PodcastEpisode());
        $this->repository->save($podcast);
    }
}
