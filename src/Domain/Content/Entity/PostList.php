<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\TimestampTrait;
use Domain\Shared\Entity\UuidTrait;
use Symfony\Component\Uid\Uuid;

/**
 * class PostList.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PostList
{
    use IdentityTrait;
    use TimestampTrait;
    use OwnerTrait;
    use UuidTrait;

    private ?string $name = null;

    private ?string $description = null;

    private bool $is_public = false;

    /**
     * @var Collection<Post>
     */
    private Collection $posts;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->posts = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsPublic(): bool
    {
        return $this->is_public;
    }

    public function setIsPublic(bool $is_public): self
    {
        $this->is_public = $is_public;

        return $this;
    }
}
