<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\EmailUserCommand;
use Domain\Authentication\Event\UserEmailedEvent;
use Domain\Authentication\Exception\UserEmailNotFoundException;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class EmailUserHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class EmailUserHandler
{
    public function __construct(
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(EmailUserCommand $command): void
    {
        if (null === $command->user->getEmail()) {
            throw new UserEmailNotFoundException();
        }

        $this->dispatcher->dispatch(new UserEmailedEvent(
            user: $command->user,
            subject: (string) $command->subject,
            message: (string) $command->message
        ));
    }
}
