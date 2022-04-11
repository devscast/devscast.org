<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RegenerateBackupCodeCommand;
use Domain\Authentication\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RegenerateBackupCodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RegenerateBackupCodeHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    public function __invoke(RegenerateBackupCodeCommand $command): void
    {
        $user = $command->user;
        $codes = [];
        for ($i = 0; $i <= 6; ++$i) {
            $codes[$i] = $this->generateCode();
        }

        $user->setBackupCode($codes);
        $this->repository->save($user);
    }

    private function generateCode(): int
    {
        return random_int(10 ** (6 - 1), 10 ** 6 - 1);
    }
}
