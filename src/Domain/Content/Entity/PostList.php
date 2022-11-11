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

    private int $post_count = 0;

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

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function setPosts(Collection $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function addPost(Post $post): self
    {
        if (! $this->posts->contains($post)) {
            $this->posts[] = $post;
            $this->post_count = $this->posts->count();
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->removeElement($post);
        $this->post_count = $this->posts->count();

        return $this;
    }

    public function getPostCount(): int
    {
        return $this->post_count;
    }

    public function setPostCount(int $posts_count): self
    {
        $this->post_count = $posts_count;

        return $this;
    }
}
