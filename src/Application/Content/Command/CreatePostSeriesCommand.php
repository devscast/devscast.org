<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Technology;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreatePostSeriesCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePostSeriesCommand
{
    public function __construct(
        public readonly User $owner,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\Length(min: 10)] public ?string $description = null,
        public ?Technology $technology = null,
        public Collection $tags = new ArrayCollection(),
        public ?File $thumbnail_file = null,
    ) {
    }
}
