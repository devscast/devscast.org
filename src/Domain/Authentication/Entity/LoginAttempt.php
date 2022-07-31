<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * Class LoginAttempt.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class LoginAttempt
{
    use OwnerTrait;
    use IdentityTrait;
    use TimestampTrait;

    public static function createFor(User $user): self
    {
        return (new self())->setOwner($user);
    }
}
