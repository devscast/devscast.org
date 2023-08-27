<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateTagCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Repository\TagRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateTagHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class UpdateTagHandler
{
    public function __construct(
        private TagRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateTagCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, $command->_entity));
    }
}
