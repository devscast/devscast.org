<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class ResetPasswordOngoingException
 * @package App\Application\Authentication\Exception
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordOngoingException extends AuthenticationException
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.reset_password_ongoing_request');
    }
}
