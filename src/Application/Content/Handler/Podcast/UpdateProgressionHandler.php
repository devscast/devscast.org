<?php

declare(strict_types=1);

namespace Application\Content\Handler\Podcast;

use Application\Content\Command\Podcast\UpdateProgressionCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\Podcast\ProgressionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateProgressionHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class UpdateProgressionHandler
{
    public function __construct(
        private ProgressionRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateProgressionCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
