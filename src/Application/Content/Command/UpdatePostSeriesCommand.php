<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Entity\PostSeries;
use Domain\Content\Entity\Technology;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdatePostSeriesCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostSeriesCommand
{
    public function __construct(
        public readonly PostSeries $state,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\Length(min: 10)] public ?string $description = null,
        public ?Technology $technology = null,
        public ?File $thumbnail_file = null,
    ) {
        Mapper::hydrate($this->state, $this);
    }
}
