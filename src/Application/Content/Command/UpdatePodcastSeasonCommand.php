<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\PodcastSeason;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdatePodcastSeasonCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePodcastSeasonCommand
{
    public function __construct(
        public readonly PodcastSeason $season,
        #[Assert\NotBlank] public ?string $name = null,
        #[Assert\NotBlank] public ?string $short_code = null,
        #[Assert\Length(min: 10)] public ?string $description = null,
        public ?File $thumbnail_file = null,
    ) {
        Mapper::hydrate($this->season, $this);
    }
}
