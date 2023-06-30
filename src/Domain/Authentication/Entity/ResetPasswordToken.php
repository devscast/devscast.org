<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Domain\Shared\Entity\OwnerTrait;

/**
 * Class ResetPasswordToken.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class ResetPasswordToken extends AbstractEntity
{
    use OwnerTrait;

    private ?string $token;

    public function __construct()
    {
        try {
            $this->token = substr(
                string: bin2hex(random_bytes(max(1, intval(ceil(60 / 2))))),
                offset: 0,
                length: 60
            );
        } catch (\Exception) {
            $this->token = null;
        }
    }

    public function isExpired(int $interval): bool
    {
        try {
            $expirationDate = new \DateTime('-' . $interval . ' minutes');

            return $this->getCreatedAt() < $expirationDate;
        } catch (\Exception) {
            return false;
        }
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token = null): self
    {
        $this->token = $token;

        return $this;
    }
}
