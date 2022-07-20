<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * Class Category.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Category
{
    use IdentityTrait;
    use TimestampTrait;

    private ?string $name = null;

    private ?string $description = null;

    private int $post_count = 0;

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

    public function getPostCount(): int
    {
        return $this->post_count;
    }

    public function setPostCount(int $post_count): self
    {
        $this->post_count = $post_count;

        return $this;
    }
}
