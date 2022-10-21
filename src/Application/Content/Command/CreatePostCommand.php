<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Doctrine\Common\Collections\Collection;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Category;
use Domain\Content\Entity\PostSeries;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreatePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePostCommand
{
    public ContentStatus $status;
    public EducationLevel $education_level;
    public ContentType $content_type;

    public function __construct(
        public readonly User $owner,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\NotBlank] public ?string $content = null,
        public ?Collection $tags = null,
        public ?Collection $technologies = null,
        #[Assert\GreaterThanOrEqual(0)] public int $duration = 0,
        public bool $is_commentable = true,
        public bool $is_featured = false,
        public bool $is_top_promoted = false,
        public bool $is_online = false,
        public bool $is_premium = false,
        public ?\DateTimeImmutable $scheduled_at = null,
        public ?File $thumbnail_file = null,
        public ?Category $category = null,
        public ?PostSeries $series = null,
    ) {
        $this->content_type = ContentType::post();
        $this->status = ContentStatus::draft();
        $this->education_level = EducationLevel::beginner();
    }
}
