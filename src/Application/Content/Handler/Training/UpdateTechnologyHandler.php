<?php

declare(strict_types=1);

namespace Application\Content\Handler\Training;

use Application\Content\Command\Training\UpdateTechnologyCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\Training\TechnologyRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTechnologyHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class UpdateTechnologyHandler
{
    public function __construct(
        private TechnologyRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateTechnologyCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
