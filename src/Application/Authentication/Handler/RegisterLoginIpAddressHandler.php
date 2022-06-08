<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RegisterLoginIpAddressCommand;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\LoginWithAnotherIpAddressEvent;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Domain\Authentication\Service\LoginAttemptService;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class RegisterLoginIpAddressHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class RegisterLoginIpAddressHandler
{
    public function __construct(
        private readonly LoginAttemptService $loginAttempt,
        private readonly EventDispatcherInterface $dispatcher,
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(RegisterLoginIpAddressCommand $command): void
    {
        $user = $command->user;
        $this->loginAttempt->deleteAttemptsFor($user);

        if ($user instanceof User) {
            if ($command->ip !== $user->getLastLoginIp()) {
                $this->dispatcher->dispatch(new LoginWithAnotherIpAddressEvent(
                    user: $user,
                    ip: $command->ip
                ));
            }

            $user->setLastLoginIp($command->ip)
                ->setLastLoginAt(new \DateTimeImmutable());
            $this->repository->save($user);
        }
    }
}
