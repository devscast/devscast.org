<?php

declare(strict_types=1);

namespace Application\Content\Handler\Podcast;

use Application\Content\Command\Podcast\UpdateSeasonCommand;
use Application\Content\Service\ContentService;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\Podcast\SeasonRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class UpdateSeasonHandler
{
    public function __construct(
        private SeasonRepositoryInterface $repository,
        private ContentService $contentService
    ) {
    }

    public function __invoke(UpdateSeasonCommand $command): void
    {
        $this->contentService->assertValidSlug($command);
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
