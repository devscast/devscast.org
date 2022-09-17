<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\DisconnectOAuthServiceCommand;
use Domain\Authentication\Exception\PasswordNotSetException;
use Domain\Authentication\Exception\UnsupportedOAuthServiceException;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class DisconnectOAuthServiceHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DisconnectOAuthServiceHandler
{
    public const SCOPES = [
        'github' => ['user:email'],
        'google' => [],
        'facebook' => [],
    ];

    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(DisconnectOAuthServiceCommand $command): void
    {
        if (! in_array($command->service, array_keys(self::SCOPES), true)) {
            throw new UnsupportedOAuthServiceException($command->service);
        }

        $user = $command->user;
        match ($command->service) {
            'github' => $user->setGithubId(null),
            'google' => $user->setGoogleId(null),
            'facebook' => $user->setFacebookId(null)
        };

        if (null === $user->getPassword() && ! $user->useOauth()) {
            throw new PasswordNotSetException();
        }

        $this->repository->save($user);
    }
}
