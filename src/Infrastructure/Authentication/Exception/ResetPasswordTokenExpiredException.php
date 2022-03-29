<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\ResetPasswordTokenExpiredException as ResetPasswordTokenExpiredExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class ResetPasswordTokenExpiredException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordTokenExpiredException extends CustomUserMessageAuthenticationException implements ResetPasswordTokenExpiredExceptionInterface
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.reset_password_token_expired');
    }
}
