<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Technology;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdateTechnologyCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTechnologyCommand
{
    public function __construct(
        public readonly Technology $technology,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\Length(min: 10)] public ?string $description = null,
        public ?File $thumbnail_file = null,
    ) {
    }
}
