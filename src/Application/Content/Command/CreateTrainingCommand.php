<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Authentication\Entity\User;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateTrainingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateTrainingCommand
{
    public ContentStatus $status;
    public EducationLevel $education_level;
    public ContentType $content_type;

    public function __construct(
        public readonly User $owner,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        public ?string $content = null,
        public Collection $tags = new ArrayCollection(),
        public Collection $technologies = new ArrayCollection(),
        #[Assert\GreaterThanOrEqual(0)] public int $duration = 0,
        public bool $is_commentable = true,
        public bool $is_featured = false,
        public bool $is_top_promoted = false,
        public bool $is_online = false,
        public bool $is_premium = false,
        public ?\DateTimeImmutable $scheduled_at = null,
        public ?File $thumbnail_file = null,
        public ?string $youtube_playlist = null,
        public ?string $links = null,
    ) {
        $this->content_type = ContentType::training();
    }
}
