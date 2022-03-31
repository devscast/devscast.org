<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * Class LoginAttempt.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class LoginAttempt
{
    use IdentityTrait;
    use TimestampTrait;

    private ?User $user = null;

    public static function createFor(User $user): self
    {
        return (new self())->setUser($user);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
