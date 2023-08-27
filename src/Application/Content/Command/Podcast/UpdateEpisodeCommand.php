<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Application\Content\Command\AbstractContentCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Podcast\Episode;
use Domain\Content\Entity\Podcast\Season;
use Domain\Content\Enum\ContentType;
use Symfony\Component\HttpFoundation\File\File;

/**
 * class UpdatePodcastEpisodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateEpisodeCommand extends AbstractContentCommand
{
    public function __construct(
        public Episode $_entity,
        public ?Season $season = null,
        public ?File $audio_file = null,
        public ?int $episode_number = null,
        public ContentType $content_type = ContentType::PODCAST,
    ) {
        Mapper::hydrate($this->_entity, $this, ['content_type']);
    }
}
