<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\UserBannedException as UserBannedExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class UserBannedException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserBannedException extends CustomUserMessageAuthenticationException implements UserBannedExceptionInterface
{
    public function __construct()
    {
        parent::__construct(message: 'authentication.exceptions.user_banned');
    }
}
