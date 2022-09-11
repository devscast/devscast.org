<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ConfirmRegistrationCommand;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Event\UserRegistrationConfirmedEvent;
use Domain\Authentication\Exception\InvalidRegistrationTokenException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class ConfirmRegistrationHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ConfirmRegistrationHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(ConfirmRegistrationCommand $command): void
    {
        /** @var User|null $user */
        $user = $this->repository->findOneByCaseInsensitive([
            'email_verification_token' => $command->token,
        ]);
        if (null === $user) {
            throw new InvalidRegistrationTokenException();
        }

        $user->setEmailVerificationToken(null)
            ->setIsEmailVerified(true);
        $this->repository->save($user);
        $this->dispatcher->dispatch(new UserRegistrationConfirmedEvent($user));
    }
}
