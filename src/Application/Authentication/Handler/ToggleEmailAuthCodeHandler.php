<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ToggleEmailAuthCodeCommand;
use Domain\Authentication\Event\TwoFactorAuthDisabledEvent;
use Domain\Authentication\Event\TwoFactorAuthEnabledEvent;
use Domain\Authentication\Repository\UserRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class ToggleEmailAuthCodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ToggleEmailAuthCodeHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(ToggleEmailAuthCodeCommand $command): void
    {
        $user = $command->user;
        if ($user->isEmailAuthEnabled()) {
            $user->disableEmailAuthCode();
            $this->dispatcher->dispatch(new TwoFactorAuthDisabledEvent($user, 'email'));
        } else {
            $user->enableEmailAuthCode();
            $this->dispatcher->dispatch(new TwoFactorAuthEnabledEvent($user, 'email'));
        }

        $this->repository->save($user);
    }
}
