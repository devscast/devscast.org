<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\ThumbnailTrait;
use Domain\Shared\Entity\TimestampTrait;
use Domain\Shared\Entity\UuidTrait;
use Symfony\Component\Uid\Uuid;

/**
 * class Technology.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Technology
{
    use IdentityTrait;
    use TimestampTrait;
    use ThumbnailTrait;
    use UuidTrait;

    private ?string $name = null;

    private ?string $slug = null;

    private ?string $description = null;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
