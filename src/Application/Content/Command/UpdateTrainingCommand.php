<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Training;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdateTrainingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTrainingCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly Training $training,
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
        public ?string $youtube_playlist = null,
        public ?string $links = null,
    ) {
        Mapper::hydrate($this->training, $this);
    }
}
