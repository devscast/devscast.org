<?php

declare(strict_types=1);

namespace Domain\Authentication\Enum;

/**
 * Class Role
 * @package App\Application\Authentication\Enum
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class Role
{
    public const ADMIN = 'ROLE_ADMIN';
    public const USER = 'ROLE_USER';
}
