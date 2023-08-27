<?php

declare(strict_types=1);

namespace Application\Content\Handler\Podcast;

use Application\Content\Command\Podcast\CreateEpisodeCommand;
use Application\Content\Service\ContentService;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Podcast\Episode;
use Domain\Content\Enum\Status;
use Domain\Content\Repository\ContentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class CreateEpisodeHandler
{
    public function __construct(
        private ContentRepositoryInterface $repository,
        private ContentService $contentService
    ) {
    }

    public function __invoke(CreateEpisodeCommand $command): void
    {
        $this->contentService->assertScheduleDateInFuture($command);
        $this->contentService->assertValidSlug($command);

        if (true === $command->is_top_promoted && Status::PUBLISHED === $command->status) {
            $this->repository->resetTopPromotedContent(Episode::class);
        }

        $this->repository->save(Mapper::getHydratedObject($command, new Episode()));
    }
}
