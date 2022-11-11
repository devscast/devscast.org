<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTechnologyCommand;
use Application\Content\Service\ContentService;
use Application\Shared\Mapper;
use Domain\Content\Entity\Technology;
use Domain\Content\Repository\TechnologyRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTechnologyHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateTechnologyHandler
{
    public function __construct(
        private readonly TechnologyRepositoryInterface $repository,
        private readonly ContentService $contentService,
    ) {
    }

    public function __invoke(CreateTechnologyCommand $command): void
    {
        $this->contentService->assertValidSlug($command);
        $this->repository->save(Mapper::getHydratedObject($command, new Technology()));
    }
}
