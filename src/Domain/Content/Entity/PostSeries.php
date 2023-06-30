<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Devscast\Bundle\DddBundle\Domain\Entity\ThumbnailTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\ValueObject\EmbeddedFile;

/**
 * class PostSeries.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PostSeries extends AbstractEntity
{
    use ThumbnailTrait;
    use OwnerTrait;

    private ?string $name = null;

    private ?string $slug = null;

    private ?string $description = null;

    private ContentStatus $status;

    private ?Technology $technology = null;

    private int $post_count = 0;

    /**
     * @var Collection<Post>
     */
    private Collection $posts;

    public function __construct()
    {
        $this->status = ContentStatus::draft();
        $this->thumbnail = EmbeddedFile::default();
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

    public function getStatus(): ContentStatus
    {
        return $this->status;
    }

    public function setStatus(ContentStatus|string $status): self
    {
        $this->status = match (true) {
            $status instanceof ContentStatus => $status,
            default => ContentStatus::fromString($status)
        };

        return $this;
    }

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): self
    {
        $this->technology = $technology;

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

    public function setPosts(Collection $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function addPost(Post $post): self
    {
        if (! $this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setSeries($this);
            $this->post_count = $this->posts->count();
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            if ($post->getSeries() === $this) {
                $post->setSeries(null);
                $this->post_count = $this->posts->count();
            }
        }

        return $this;
    }
}
