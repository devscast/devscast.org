<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\ThumbnailTrait;
use Domain\Shared\Entity\TimestampTrait;
use Domain\Shared\Entity\UuidTrait;
use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\Uid\Uuid;

/**
 * Class Content.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Content
{
    use OwnerTrait;
    use IdentityTrait;
    use TimestampTrait;
    use ThumbnailTrait;
    use UuidTrait;

    private ?string $name = null;

    private ?string $slug = null;

    private ?string $content = null;

    private ContentStatus $status;

    private ContentType $content_type;

    private EducationLevel $education_level;

    private int $up_vote_count = 0;

    private int $down_vote_count = 0;

    private int $average_vote_count = 0;

    /**
     * @var Collection<Tag>
     */
    private Collection $tags;

    /**
     * @var Collection<Technology>
     */
    private Collection $technologies;

    private ?int $duration = null;

    private bool $is_commentable = true;

    private bool $is_featured = false;

    private bool $is_top_promoted = false;

    private bool $is_online = false;

    private bool $is_premium = false;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->content_type = ContentType::post();
        $this->status = ContentStatus::draft();
        $this->thumbnail = EmbeddedFile::default();
        $this->education_level = EducationLevel::beginner();
        $this->tags = new ArrayCollection();
        $this->technologies = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function setTags(Collection $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getContentType(): ContentType
    {
        return $this->content_type;
    }

    public function setContentType(ContentType|string $content_type): self
    {
        $this->content_type = match (true) {
            $content_type instanceof ContentType => $content_type,
            default => ContentType::fromString($content_type)
        };

        return $this;
    }

    public function isIsCommentable(): bool
    {
        return $this->is_commentable;
    }

    public function setIsCommentable(bool $is_commentable): self
    {
        $this->is_commentable = $is_commentable;

        return $this;
    }

    public function isIsFeatured(): bool
    {
        return $this->is_featured;
    }

    public function setIsFeatured(bool $is_featured): self
    {
        $this->is_featured = $is_featured;

        return $this;
    }

    public function isIsTopPromoted(): bool
    {
        return $this->is_top_promoted;
    }

    public function setIsTopPromoted(bool $is_top_promoted): self
    {
        $this->is_top_promoted = $is_top_promoted;

        return $this;
    }

    public function isIsOnline(): bool
    {
        return $this->is_online;
    }

    public function setIsOnline(bool $is_online): self
    {
        $this->is_online = $is_online;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function isIsPremium(): bool
    {
        return $this->is_premium;
    }

    public function setIsPremium(bool $is_premium): self
    {
        $this->is_premium = $is_premium;

        return $this;
    }

    public function getEducationLevel(): EducationLevel
    {
        return $this->education_level;
    }

    public function setEducationLevel(EducationLevel|string $education_level): self
    {
        $this->education_level = match (true) {
            $education_level instanceof EducationLevel => $education_level,
            default => EducationLevel::fromString($education_level)
        };

        return $this;
    }
}
