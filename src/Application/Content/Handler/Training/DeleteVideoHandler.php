<?php

declare(strict_types=1);

namespace Application\Content\Handler\Training;

use Application\Content\Command\Training\DeleteVideoCommand;
use Domain\Content\Repository\Training\VideoRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteVideoHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final readonly class DeleteVideoHandler
{
    public function __construct(
        private VideoRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteVideoCommand $command): void
    {
        $this->repository->delete($command->_entity);
    }
}
