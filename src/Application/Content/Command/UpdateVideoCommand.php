<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Entity\Training;
use Domain\Content\Entity\Video;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\EducationLevel;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdateVideoCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateVideoCommand
{
    public ContentStatus $status;
    public EducationLevel $education_level;

    public function __construct(
        public readonly Video $video,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        public ?string $content = null,
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
        public ?string $source_url = null,
        public ?string $timecodes = null,
        public ?Training $training = null,
    ) {
        Mapper::hydrate($this->video, $this);
    }
}
