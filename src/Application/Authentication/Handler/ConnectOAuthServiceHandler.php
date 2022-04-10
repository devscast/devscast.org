<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ConnectOAuthServiceCommand;
use Infrastructure\Authentication\Exception\UnsupportedOAuthServiceException;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class ConnectOAuthServiceHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ConnectOAuthServiceHandler implements MessageHandlerInterface
{
    public const SCOPES = [
        'github' => ['user:email'],
        'google' => [],
    ];

    public function __construct(
        private readonly ClientRegistry $clientRegistry,
    ) {
    }

    public function __invoke(ConnectOAuthServiceCommand $command): RedirectResponse
    {
        if (! in_array($command->service, array_keys(self::SCOPES), true)) {
            throw new UnsupportedOAuthServiceException($command->service);
        }

        return $this->clientRegistry
            ->getClient($command->service)
            ->redirect(
                scopes: self::SCOPES[$command->service],
                options: [
                    'a' => 1,
                ]
            );
    }
}
