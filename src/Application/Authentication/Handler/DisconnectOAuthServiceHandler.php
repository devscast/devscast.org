<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\DisconnectOAuthServiceCommand;
use Domain\Authentication\Repository\UserRepository;
use Infrastructure\Authentication\Exception\UnsupportedOAuthServiceException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class DisconnectOAuthServiceHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DisconnectOAuthServiceHandler implements MessageHandlerInterface
{
    public const SCOPES = [
        'github' => ['user:email'],
        'google' => [],
    ];

    public function __construct(
        private readonly UserRepository $repository
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
            'google' => $user->setGoogleId(null)
        };
        $this->repository->save($user);
    }
}
