<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePodcastEpisodeCommand;
use Application\Content\Service\ContentService;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\PodcastEpisodeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePodcastEpisodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePodcastEpisodeHandler
{
    public function __construct(
        private readonly PodcastEpisodeRepositoryInterface $repository,
        private readonly ContentService $contentService,
    ) {
    }

    public function __invoke(UpdatePodcastEpisodeCommand $command): void
    {
        $this->contentService->assertPublishableContent($command);
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
