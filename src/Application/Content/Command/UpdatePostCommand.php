<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Category;
use Domain\Content\Entity\Post;
use Domain\Content\Entity\PostSeries;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdatePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly Post $post,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\NotBlank] public ?string $content = null,
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
        public ?Category $category = null,
        public ?PostSeries $series = null,
    ) {
        Mapper::hydrate($this->post, $this);
    }
}
