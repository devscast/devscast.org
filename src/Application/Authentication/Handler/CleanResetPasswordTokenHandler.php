<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\CleanResetPasswordTokenCommand;
use Domain\Authentication\Repository\ResetPasswordTokenRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CleanResetPasswordTokenHandler
{
    public function __construct(
        private readonly ResetPasswordTokenRepositoryInterface $repository
    ) {
    }

    public function __invoke(CleanResetPasswordTokenCommand $command): void
    {
        $this->repository->clean();
    }
}
