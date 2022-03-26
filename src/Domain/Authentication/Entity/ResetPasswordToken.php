<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * Class ResetPasswordToken.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordToken
{
    use IdentityTrait;
    use TimestampTrait;

    private ?string $token = null;

    private ?User $user = null;

    public function isExpired(int $interval): bool
    {
        try {
            $expirationDate = new \DateTime('-' . $interval . ' minutes');

            return $this->getCreatedAt() < $expirationDate;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
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
