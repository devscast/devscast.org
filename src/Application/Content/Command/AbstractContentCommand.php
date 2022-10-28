<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class ContentCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractContentCommand
{
    public ContentStatus $status;
    public EducationLevel $education_level;
    public ContentType $content_type;

    public readonly User $owner;
    #[Assert\NotBlank] public ?string $name = null;
    public ?string $slug = null;
    #[Assert\NotBlank] public ?string $content = null;
    public array $tags = [];
    public array $technologies = [];
    #[Assert\GreaterThanOrEqual(0)] public int $duration = 0;
    public bool $is_commentable = true;
    public bool $is_featured = false;
    public bool $is_top_promoted = false;
    public bool $is_online = false;
    public bool $is_premium = false;
    public ?\DateTimeInterface $scheduled_at = null;
    public ?File $thumbnail_file = null;
}
