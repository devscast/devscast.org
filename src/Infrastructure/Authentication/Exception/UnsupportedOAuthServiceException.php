<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\UnsupportedOAuthServiceException as UnsupportedOAuthServiceExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class UnsupportedOAuthServiceException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UnsupportedOAuthServiceException extends CustomUserMessageAuthenticationException implements UnsupportedOAuthServiceExceptionInterface
{
    public function __construct(string $service)
    {
        $this->setSafeMessage(
            messageKey: 'authentication.exceptions.unsupported_oauth_service',
            messageData: [
                'service' => $service,
            ]
        );
        parent::__construct();
    }
}
