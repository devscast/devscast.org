<?php

declare(strict_types=1);

namespace Application\Content\Handler\Podcast;

use Application\Content\Command\Podcast\UpdateEpisodeCommand;
use Application\Content\Service\ContentService;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\Podcast\EpisodeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class UpdateEpisodeHandler
{
    public function __construct(
        private EpisodeRepositoryInterface $repository,
        private ContentService $contentService,
    ) {
    }

    public function __invoke(UpdateEpisodeCommand $command): void
    {
        $this->contentService->assertPublishableContent($command);
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
