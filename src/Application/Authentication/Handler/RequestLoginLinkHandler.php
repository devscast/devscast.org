<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\RequestLoginLinkCommand;
use Domain\Authentication\Event\LoginLinkRequestedEvent;
use Domain\Authentication\Exception\UserNotFoundException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

/**
 * Class RequestLoginLinkHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class RequestLoginLinkHandler
{
    public function __construct(
        private readonly LoginLinkHandlerInterface $loginLinkHandler,
        private readonly UserRepositoryInterface $repository,
        private readonly EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(RequestLoginLinkCommand $command): void
    {
        $user = $this->repository->findOneByEmail((string) $command->email);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        $loginLinkDetails = $this->loginLinkHandler->createLoginLink($user);
        $this->dispatcher->dispatch(new LoginLinkRequestedEvent($user, $loginLinkDetails));
    }
}
