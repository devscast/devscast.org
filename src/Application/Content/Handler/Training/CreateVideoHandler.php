<?php

declare(strict_types=1);

namespace Application\Content\Handler\Training;

use Application\Content\Command\Training\CreateVideoCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Training\Video;
use Domain\Content\Repository\Training\VideoRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateVideoHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class CreateVideoHandler
{
    public function __construct(
        private VideoRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateVideoCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new Video()));
    }
}
