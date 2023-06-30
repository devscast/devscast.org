<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Domain\Shared\Entity\OwnerTrait;

/**
 * Class LoginAttempt.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class LoginAttempt extends AbstractEntity
{
    use OwnerTrait;

    public static function createFor(User $user): self
    {
        return (new self())->setOwner($user);
    }
}
