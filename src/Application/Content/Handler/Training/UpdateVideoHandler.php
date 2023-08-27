<?php

declare(strict_types=1);

namespace Application\Content\Handler\Training;

use Application\Content\Command\Training\UpdateVideoCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\Training\VideoRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateVideoCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class UpdateVideoHandler
{
    public function __construct(
        private VideoRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateVideoCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
