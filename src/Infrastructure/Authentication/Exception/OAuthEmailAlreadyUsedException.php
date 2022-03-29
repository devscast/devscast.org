<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\OAuthEmailAlreadyUsedException as OAuthEmailAlreadyUsedExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class OAuthEmailAlreadyUsedException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OAuthEmailAlreadyUsedException extends CustomUserMessageAuthenticationException implements OAuthEmailAlreadyUsedExceptionInterface
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.oauth_email_already_used');
    }
}
