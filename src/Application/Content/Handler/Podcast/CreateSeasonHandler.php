<?php

declare(strict_types=1);

namespace Application\Content\Handler\Podcast;

use Application\Content\Command\Podcast\CreateSeasonCommand;
use Application\Content\Service\ContentService;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Podcast\Season;
use Domain\Content\Repository\Podcast\SeasonRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePodcastSeasonHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class CreateSeasonHandler
{
    public function __construct(
        private SeasonRepositoryInterface $repository,
        private ContentService $contentService,
    ) {
    }

    public function __invoke(CreateSeasonCommand $command): void
    {
        $this->contentService->assertValidSlug($command);
        $this->repository->save(Mapper::getHydratedObject($command, new Season()));
    }
}
