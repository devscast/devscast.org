<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\EducationLevel;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\ThumbnailTrait;
use Domain\Shared\Entity\TimestampTrait;
use Domain\Shared\Entity\UuidTrait;
use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\Uid\Uuid;

/**
 * class PostSeries.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PostSeries
{
    use IdentityTrait;
    use TimestampTrait;
    use ThumbnailTrait;
    use OwnerTrait;
    use UuidTrait;

    private ?string $name = null;

    private ?string $slug = null;

    private ?string $description = null;

    private ContentStatus $status;

    private ?Technology $technology = null;

    /**
     * @var Collection<Tag>
     */
    private Collection $tags;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->status = ContentStatus::draft();
        $this->thumbnail = EmbeddedFile::default();
        $this->tags = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): PostSeries
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): PostSeries
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): PostSeries
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ContentStatus
    {
        return $this->status;
    }

    public function setStatus(ContentStatus $status): PostSeries
    {
        $this->status = $status;
        return $this;
    }

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): PostSeries
    {
        $this->technology = $technology;
        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function setTags(Collection $tags): PostSeries
    {
        $this->tags = $tags;
        return $this;
    }
}
