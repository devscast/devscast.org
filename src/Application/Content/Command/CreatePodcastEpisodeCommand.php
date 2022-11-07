<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\PodcastSeason;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Domain\Content\ValueObject\PodcastEpisodeType;
use Symfony\Component\HttpFoundation\File\File;

/**
 * class CreatePodcastEpisodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePodcastEpisodeCommand extends AbstractContentCommand
{
    public PodcastEpisodeType $episode_type;

    public function __construct(
        public ?User $owner = null,
        public ?PodcastSeason $season = null,
        public ?File $audio_file = null,
        public ?int $episode_number = null
    ) {
        $this->content_type = ContentType::podcast();
        $this->education_level = EducationLevel::beginner();
        $this->episode_type = PodcastEpisodeType::full();
        $this->status = ContentStatus::draft();
    }
}
