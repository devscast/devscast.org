<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ToggleTwoFactorCommand;
use Domain\Authentication\Event\TwoFactorDisabledEvent;
use Domain\Authentication\Event\TwoFactorEnabledEvent;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class ToggleTwoFactorHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ToggleTwoFactorHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(ToggleTwoFactorCommand $command): void
    {
        $user = $command->user;
        $status = $user->isTwoFactorEnabled();

        $command->email ? $user->enableEmailAuthCode() : $user->disableEmailAuthCode();
        $command->google ? $user->enableGoogleAuthenticator() : $user->disableGoogleAuthenticator();
        $this->repository->save($user);

        if (false === $user->isTwoFactorEnabled() && $user->isTwoFactorEnabled() !== $status) {
            $this->dispatcher->dispatch(new TwoFactorDisabledEvent($user));
        }

        if (true === $user->isTwoFactorEnabled() && $user->isTwoFactorEnabled() !== $status) {
            $this->dispatcher->dispatch(new TwoFactorEnabledEvent($user));
        }
    }
}
