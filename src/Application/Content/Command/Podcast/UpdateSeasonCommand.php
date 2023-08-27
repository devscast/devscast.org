<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Podcast\Season;
use Symfony\Component\HttpFoundation\File\File;

/**
 * class UpdatePodcastSeasonCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateSeasonCommand
{
    public function __construct(
        public readonly Season $_entity,
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $short_code = null,
        public ?string $description = null,
        public ?File $thumbnail_file = null,
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
