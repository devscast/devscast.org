<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

use Symfony\Component\Uid\Uuid;

trait UuidTrait
{
    protected Uuid $uuid;

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid|string $uuid): self
    {
        $this->uuid = match (true) {
            $uuid instanceof Uuid => $uuid,
            default => Uuid::fromString($uuid)
        };

        return $this;
    }
}
