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

    protected ?string $name = null;

    protected ?string $slug = null;

    protected ?string $content = null;

    protected ContentStatus $status;

    protected ContentType $content_type;

    protected EducationLevel $education_level;

    protected int $up_vote_count = 0;

    protected int $down_vote_count = 0;

    protected float $ratio_vote_count = 0.0;

    /**
     * @var Collection<Tag>
     */
    protected Collection $tags;

    /**
     * @var Collection<Technology>
     */
    protected Collection $technologies;

    protected ?int $duration = null;

    protected bool $is_commentable = true;

    protected bool $is_featured = false;

    protected bool $is_top_promoted = false;

    protected bool $is_online = false;

    protected bool $is_premium = false;

    protected ?\DateTimeImmutable $scheduled_at = null;

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
    }

    public function addTag(Tag $tag): self
    {
        if (! $this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

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

    public function getUpVoteCount(): int
    {
        return $this->up_vote_count;
    }

    public function setUpVoteCount(int $up_vote_count): self
    {
        $this->up_vote_count = $up_vote_count;

        return $this;
    }

    public function getDownVoteCount(): int
    {
        return $this->down_vote_count;
    }

    public function setDownVoteCount(int $down_vote_count): self
    {
        $this->down_vote_count = $down_vote_count;

        return $this;
    }

    public function getScheduledAt(): ?\DateTimeImmutable
    {
        return $this->scheduled_at;
    }

    public function setScheduledAt(\DateTimeInterface|string|null $scheduled_at): self
    {
        $this->scheduled_at = $this->createDateTime($scheduled_at);

        return $this;
    }

    public function getRatioVoteCount(): float
    {
        return $this->ratio_vote_count;
    }

    public function setRatioVoteCount(float $ratio_vote_count): self
    {
        $this->ratio_vote_count = $ratio_vote_count;

        return $this;
    }

    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (! $this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }
}
