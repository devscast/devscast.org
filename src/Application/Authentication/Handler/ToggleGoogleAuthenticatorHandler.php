<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ToggleGoogleAuthenticatorCommand;
use Domain\Authentication\Event\TwoFactorAuthDisabledEvent;
use Domain\Authentication\Event\TwoFactorAuthEnabledEvent;
use Domain\Authentication\Repository\UserRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticator;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class ToggleEmailAuthCodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ToggleGoogleAuthenticatorHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly GoogleAuthenticator $authenticator,
        private readonly UserRepository $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(ToggleGoogleAuthenticatorCommand $command): void
    {
        $user = $command->user;
        if ($user->isGoogleAuthenticatorEnabled()) {
            $user->disableGoogleAuthenticator();
            $this->dispatcher->dispatch(new TwoFactorAuthDisabledEvent($user, 'google'));
        } else {
            $user->enableGoogleAuthenticator()
                ->setGoogleAuthenticatorSecret($this->authenticator->generateSecret());
            $this->dispatcher->dispatch(new TwoFactorAuthEnabledEvent($user, 'google'));
        }

        $this->repository->save($user);
    }
}
