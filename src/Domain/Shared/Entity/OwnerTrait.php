<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

use Domain\Authentication\Entity\User;

/**
 * trait OwnerTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait OwnerTrait
{
    protected ?User $owner;

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $author): self
    {
        $this->owner = $author;

        return $this;
    }
}
