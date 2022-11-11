<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePostSeriesCommand;
use Application\Content\Service\ContentService;
use Application\Shared\Mapper;
use Domain\Content\Entity\PostSeries;
use Domain\Content\Repository\PostSeriesRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePostSeriesHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePostSeriesHandler
{
    public function __construct(
        private readonly PostSeriesRepositoryInterface $repository,
        private readonly ContentService $contentService
    ) {
    }

    public function __invoke(CreatePostSeriesCommand $command): void
    {
        $this->contentService->assertValidSlug($command);
        $this->repository->save(Mapper::getHydratedObject($command, new PostSeries()));
    }
}
