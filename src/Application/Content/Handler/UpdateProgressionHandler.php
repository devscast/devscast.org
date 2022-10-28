<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateProgressionCommand;
use Application\Shared\Mapper;
use Domain\Content\Repository\ProgressionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateProgressionHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateProgressionHandler
{
    public function __construct(
        private readonly ProgressionRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateProgressionCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->progression));
    }
}
