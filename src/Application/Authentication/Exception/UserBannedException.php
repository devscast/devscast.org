<?php

declare(strict_types=1);

namespace Application\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class UserBannedException
 * @package App\Application\Authentication\Exception
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserBannedException extends CustomUserMessageAuthenticationException
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.user_banned');
    }
}
