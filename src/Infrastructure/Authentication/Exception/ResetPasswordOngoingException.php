<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\ResetPasswordOngoingException as ResetPasswordOngoingExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class ResetPasswordOngoingException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordOngoingException extends CustomUserMessageAuthenticationException implements ResetPasswordOngoingExceptionInterface
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.reset_password_ongoing_request');
    }
}
