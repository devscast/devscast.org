<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteTagCommand;
use Domain\Content\Repository\TagRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteTagHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class DeleteTagHandler
{
    public function __construct(
        private TagRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteTagCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
