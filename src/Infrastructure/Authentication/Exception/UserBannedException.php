<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class UserBannedException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserBannedException extends CustomUserMessageAuthenticationException
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.user_banned');
    }
}
