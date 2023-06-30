<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreatePodcastSeasonCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePodcastSeasonCommand
{
    public function __construct(
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\NotBlank] public ?string $short_code = null,
        public ?string $description = null,
        public ?File $thumbnail_file = null,
    ) {
    }
}
