<?php

declare(strict_types=1);

namespace Domain\Authentication\ValueObject;

/**
 * Class Role.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class Role
{
    final public const ADMIN = 'ROLE_ADMIN';
    final public const USER = 'ROLE_USER';
    final public const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
}
