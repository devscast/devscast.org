<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\GenerateBackupCodeCommand;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class GenerateBackupCodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class GenerateBackupCodeHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(GenerateBackupCodeCommand $command): void
    {
        $user = $command->user;
        $codes = [];
        for ($i = 0; $i <= 5; ++$i) {
            $codes[$i] = $this->generateCode();
        }

        $user->setBackupCodes($codes);
        $this->repository->save($user);
    }

    private function generateCode(): int
    {
        try {
            return \random_int(10 ** (6 - 1), 10 ** 6 - 1);
        } catch (\Throwable) {
            return rand(100000, 999999);
        }
    }
}
