<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTechnologyCommand;
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
        private readonly TechnologyRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateTechnologyCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new Technology()));
    }
}
