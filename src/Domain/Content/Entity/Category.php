<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    private Collection $posts;

    public function __construct()
    {
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

    public function getPostCount(): int
    {
        return $this->post_count;
    }

    public function setPostCount(int $post_count): self
    {
        $this->post_count = $post_count;

        return $this;
    }

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (! $this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCategory($this);
            $this->post_count = $this->posts->count();
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
                $this->post_count = $this->posts->count();
            }
        }

        return $this;
    }
}
