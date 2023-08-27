<?php

declare(strict_types=1);

namespace Application\Content\Handler\Training;

use Application\Content\Command\Training\CreateTechnologyCommand;
use Application\Content\Service\ContentService;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Training\Technology;
use Domain\Content\Repository\Training\TechnologyRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTechnologyHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class CreateTechnologyHandler
{
    public function __construct(
        private TechnologyRepositoryInterface $repository,
        private ContentService $contentService,
    ) {
    }

    public function __invoke(CreateTechnologyCommand $command): void
    {
        $this->contentService->assertValidSlug($command);
        $this->repository->save(Mapper::getHydratedObject($command, new Technology()));
    }
}
