<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Devscast\Bundle\DddBundle\Domain\Entity\ThumbnailTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Enum\ContentType;
use Domain\Content\Enum\EducationLevel;
use Domain\Content\Enum\Status;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\ValueObject\EmbeddedFile;

/**
 * Class Content.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class Content extends AbstractEntity
{
    use OwnerTrait;
    use ThumbnailTrait;

    private const VIEW_MILESTONES = [100, 500, 1_000, 2_500, 5_000, 10_000];

    protected ?string $name = null;

    protected ?string $slug = null;

    protected ?string $content = null;

    protected Status $status = Status::DRAFT;

    protected ContentType $content_type = ContentType::PODCAST;

    protected EducationLevel $education_level = EducationLevel::BEGINNER;

    protected int $comment_count = 0;

    protected int $unique_view_count = 0;

    protected int $view_count = 0;

    protected int $last_view_milestone_reached = 0;

    /**
     * @var Collection<Tag>
     */
    protected Collection $tags;

    /**
     * @var Collection<Comment>
     */
    protected Collection $comments;

    protected ?int $duration = null;

    protected bool $is_commentable = true;

    protected bool $is_featured = false;

    protected bool $is_top_promoted = false;

    protected bool $is_online = false;

    protected bool $is_premium = false;

    protected bool $is_community = false;

    protected ?\DateTimeImmutable $scheduled_at = null;

    public function __construct()
    {
        $this->thumbnail = EmbeddedFile::default();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status|string $status): self
    {
        $this->status = match (true) {
            $status instanceof Status => $status,
            default => Status::from($status)
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

    abstract public function getContentType(): ContentType;

    public function setContentType(ContentType|string|null $content_type): self
    {
        $this->content_type = match (true) {
            $content_type instanceof ContentType => $content_type,
            default => ContentType::from((string) $content_type)
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
            default => EducationLevel::from($education_level)
        };

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

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (! $this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTarget($this);
            $this->comment_count = $this->comments->count();
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        $this->comments->removeElement($comment);
        $this->comment_count = $this->comments->count();

        return $this;
    }

    public function getCommentCount(): int
    {
        return $this->comment_count;
    }

    public function setCommentCount(int $comments_count): self
    {
        $this->comment_count = $comments_count;

        return $this;
    }

    public function getUniqueViewCount(): int
    {
        return $this->unique_view_count;
    }

    public function setUniqueViewCount(int $unique_view_count): self
    {
        $this->unique_view_count = $unique_view_count;

        return $this;
    }

    public function getViewCount(): int
    {
        return $this->view_count;
    }

    public function setViewCount(int $view_count): self
    {
        $this->view_count = $view_count;

        return $this;
    }

    public function increaseViewCount(): self
    {
        ++$this->view_count;

        return $this;
    }

    public function increaseUniqueViewCount(): self
    {
        ++$this->unique_view_count;

        return $this;
    }

    public function getLastViewMilestoneReached(): int
    {
        return $this->last_view_milestone_reached;
    }

    public function setLastViewMilestoneReached(int $last): self
    {
        $this->last_view_milestone_reached = $last;

        return $this;
    }

    public function hasReachedViewMilestone(): bool
    {
        if (
            in_array($this->unique_view_count, self::VIEW_MILESTONES, true) &&
            $this->last_view_milestone_reached < $this->unique_view_count
        ) {
            $this->last_view_milestone_reached = $this->unique_view_count;

            return true;
        }

        return false;
    }

    public function isIsCommunity(): bool
    {
        return $this->is_community;
    }

    public function setIsCommunity(bool $is_community): self
    {
        $this->is_community = $is_community;

        return $this;
    }
}
