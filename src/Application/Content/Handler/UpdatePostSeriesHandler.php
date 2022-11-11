<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdatePostSeriesCommand;
use Application\Content\Service\ContentService;
use Application\Shared\Mapper;
use Domain\Content\Repository\PostSeriesRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdatePostSeriesHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdatePostSeriesHandler
{
    public function __construct(
        private readonly PostSeriesRepositoryInterface $repository,
        private readonly ContentService $contentService
    ) {
    }

    public function __invoke(UpdatePostSeriesCommand $command): void
    {
        $this->contentService->assertValidSlug($command);
        $this->repository->save(Mapper::getHydratedObject($command, $command->state));
    }
}
