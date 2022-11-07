<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\UpdateUserCommand;
use Application\Shared\Mapper;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateUserHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateUserCommand $command): void
    {
        Mapper::hydrate($command, $command->state);
        $this->repository->save($command->state);
    }
}
