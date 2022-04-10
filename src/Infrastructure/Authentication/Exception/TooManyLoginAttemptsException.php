<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\TooManyLoginAttemptsException as TooManyLoginAttemptsExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class TooManyLoginAttemptsException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TooManyLoginAttemptsException extends CustomUserMessageAuthenticationException implements TooManyLoginAttemptsExceptionInterface
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.too_many_login_attempts');
    }
}
