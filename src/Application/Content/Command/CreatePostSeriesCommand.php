<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
        public array $tags = [],
        public ?File $thumbnail_file = null,
    ) {
    }

    public function setTags(array|Collection $data): self
    {
        match (true) {
            $data instanceof Collection => $data->toArray(),
            default => new ArrayCollection($data)
        };

        return $this;
    }
}
