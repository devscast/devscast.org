<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Entity\PodcastSeason;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Domain\Content\ValueObject\PodcastEpisodeType;
use Symfony\Component\HttpFoundation\File\File;

/**
 * class UpdatePodcastEpisodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePodcastEpisodeCommand extends AbstractContentCommand
{
    public PodcastEpisodeType $episode_type;

    public function __construct(
        public PodcastEpisode $_entity,
        public ?PodcastSeason $season = null,
        public ?File $audio_file = null,
        public ?int $episode_number = null
    ) {
        $this->content_type = ContentType::podcast();
        $this->status = ContentStatus::draft();
        $this->education_level = EducationLevel::beginner();
        Mapper::hydrate($this->_entity, $this, ['content_type']);
    }
}
