<?php

declare(strict_types=1);

namespace Application\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class UserNotFoundException
 * @package App\Application\Authentication\Exception
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserNotFoundException extends AuthenticationException
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.user_not_found');
    }
}
