<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Technology;
use Symfony\Component\HttpFoundation\File\File;

/**
 * class CreatePostSeriesCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePostSeriesCommand
{
    public function __construct(
        public ?User $owner = null,
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?Technology $technology = null,
        public ?File $thumbnail_file = null,
    ) {
    }
}
