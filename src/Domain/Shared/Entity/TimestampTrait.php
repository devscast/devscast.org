<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TimestampTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait TimestampTrait
{
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\PrePersist]
    public function setCreatedAtOnPrePersist(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    #[ORM\PostUpdate]
    public function setUpdatedAtOnPostUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
