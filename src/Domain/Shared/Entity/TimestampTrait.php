<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

/**
 * Trait TimestampTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait TimestampTrait
{
    private ?\DateTimeImmutable $created_at = null;

    private ?\DateTimeImmutable $updated_at = null;

    public function setCreatedAtOnPrePersist(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function setUpdatedAtOnPostUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface|string $created_at): self
    {
        if (is_string($created_at)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $created_at);
            $this->created_at = false === $date ? null : $date;
        } elseif ($created_at instanceof \DateTimeInterface) {
            $this->created_at = \DateTimeImmutable::createFromInterface($created_at);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface|string|null $updated_at): self
    {
        if (is_string($updated_at)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $updated_at);
            $this->updated_at = false === $date ? null : $date;
        } elseif ($updated_at instanceof \DateTimeInterface) {
            $this->updated_at = \DateTimeImmutable::createFromInterface($updated_at);
        } else {
            $this->updated_at = $updated_at;
        }

        return $this;
    }
}
