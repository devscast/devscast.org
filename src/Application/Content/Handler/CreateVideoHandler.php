<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateVideoCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Video;
use Domain\Content\Repository\VideoRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateVideoHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateVideoHandler
{
    public function __construct(
        private readonly VideoRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateVideoCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new Video()));
    }
}
