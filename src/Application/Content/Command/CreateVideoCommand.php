<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Training;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateVideoCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateVideoCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly User $owner,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        public ?string $content = null,
        public array $tags = [],
        public array $technologies = [],
        #[Assert\GreaterThanOrEqual(0)] public int $duration = 0,
        public bool $is_commentable = true,
        public bool $is_featured = false,
        public bool $is_top_promoted = false,
        public bool $is_online = false,
        public bool $is_premium = false,
        public ?\DateTimeInterface $scheduled_at = null,
        public ?File $thumbnail_file = null,
        public ?string $source_url = null,
        public ?string $timecodes = null,
        public ?Training $training = null,
    ) {
        $this->content_type = ContentType::video();
        $this->status = ContentStatus::draft();
        $this->education_level = EducationLevel::beginner();
    }
}
