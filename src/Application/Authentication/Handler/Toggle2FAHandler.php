<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\Toggle2FACommand;
use Domain\Authentication\Event\TwoFactorAuthDisabledEvent;
use Domain\Authentication\Event\TwoFactorAuthEnabledEvent;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class Toggle2FAHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class Toggle2FAHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(Toggle2FACommand $command): void
    {
        $user = $command->user;
        $previous2FAStatus = $user->is2FAEnabled();

        $command->email ? $user->enableEmailAuthCode() : $user->disableEmailAuthCode();
        $command->google ? $user->enableGoogleAuthenticator() : $user->disableGoogleAuthenticator();
        $this->repository->save($user);

        if (false === $user->is2FAEnabled() && $user->is2FAEnabled() !== $previous2FAStatus) {
            $this->dispatcher->dispatch(new TwoFactorAuthDisabledEvent($user));
        }

        if (true === $user->is2FAEnabled() && $user->is2FAEnabled() !== $previous2FAStatus) {
            $this->dispatcher->dispatch(new TwoFactorAuthEnabledEvent($user));
        }

        $this->repository->save($user);
    }
}
