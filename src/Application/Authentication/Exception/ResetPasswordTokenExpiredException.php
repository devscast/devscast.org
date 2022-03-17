<?php

declare(strict_types=1);

namespace Application\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class ResetPasswordTokenExpiredException
 * @package App\Application\Authentication\Exception
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordTokenExpiredException extends AuthenticationException
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.reset_password_token_expired');
    }
}
