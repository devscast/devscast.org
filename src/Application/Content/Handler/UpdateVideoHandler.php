<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateVideoCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\VideoRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateVideoCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateVideoHandler
{
    public function __construct(
        private readonly VideoRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateVideoCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
