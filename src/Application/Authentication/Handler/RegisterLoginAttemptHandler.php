<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RegisterLoginAttemptCommand;
use Domain\Authentication\Service\LoginAttemptService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RegisterLoginAttemptHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RegisterLoginAttemptHandler implements MessageHandlerInterface
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
