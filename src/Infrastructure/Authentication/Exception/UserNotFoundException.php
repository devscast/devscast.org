<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class UserNotFoundException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserNotFoundException extends AuthenticationException
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.user_not_found');
    }
}
