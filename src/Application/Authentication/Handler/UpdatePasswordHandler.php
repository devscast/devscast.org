<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\UpdatePasswordCommand;
use Domain\Authentication\Event\PasswordUpdatedEvent;
use Domain\Authentication\Exception\InvalidCurrentPasswordException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final class UpdatePasswordHandler
{
    public function __construct(
        public readonly UserRepositoryInterface $repository,
        public readonly UserPasswordHasherInterface $hasher,
        public readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(UpdatePasswordCommand $command): void
    {
        $user = $command->user;
        if (! $this->hasher->isPasswordValid($user, (string) $command->current)) {
            throw new InvalidCurrentPasswordException();
        }

        $user->setPassword($this->hasher->hashPassword($user, (string) $command->new));
        $this->repository->save($user);
        $this->dispatcher->dispatch(new PasswordUpdatedEvent($user));
    }
}
