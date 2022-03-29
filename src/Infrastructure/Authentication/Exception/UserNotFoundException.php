<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\UserNotFoundException as UserNotFoundExceptionInfrastructure;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class UserNotFoundException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserNotFoundException extends CustomUserMessageAuthenticationException implements UserNotFoundExceptionInfrastructure
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.user_not_found');
    }
}
