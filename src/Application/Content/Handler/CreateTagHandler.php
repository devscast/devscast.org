<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateTagCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Tag;
use Domain\Content\Repository\TagRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateTagHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class CreateTagHandler
{
    public function __construct(
        private TagRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateTagCommand $command): void
    {
        $this->repository->save(Mapper::getHydratedObject($command, new Tag()));
    }
}
