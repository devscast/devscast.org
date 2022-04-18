<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RegisterLoginAttemptCommand;
use Domain\Authentication\Service\LoginAttemptService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class RegisterLoginAttemptHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class RegisterLoginAttemptHandler
{
    public function __construct(
        private readonly LoginAttemptService $loginAttempt
    ) {
    }

    public function __invoke(RegisterLoginAttemptCommand $command): void
    {
        $this->loginAttempt->addAttempt($command->user);
    }
}
