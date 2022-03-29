<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\OAuthVerifiedEmailNotFoundException as OAuthVerifiedEmailNotFoundExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class OAuthVerifiedEmailNotFoundException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OAuthVerifiedEmailNotFoundException extends CustomUserMessageAuthenticationException implements OAuthVerifiedEmailNotFoundExceptionInterface
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.oauth_verified_email_not_found');
    }
}
