<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Entity\PodcastEpisode;
use Domain\Content\Entity\PodcastSeason;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\EducationLevel;
use Domain\Content\ValueObject\PodcastEpisodeType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdatePodcastEpisodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePodcastEpisodeCommand
{
    public ContentStatus $status;
    public EducationLevel $education_level;
    public PodcastEpisodeType $episode_type;

    public function __construct(
        public readonly PodcastEpisode $episode,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        public ?string $content = null,
        public ?Collection $tags = null,
        public ?Collection $technologies = null,
        #[Assert\GreaterThanOrEqual(0)] public int $duration = 0,
        public bool $is_commentable = true,
        public bool $is_featured = false,
        public bool $is_top_promoted = false,
        public bool $is_online = false,
        public bool $is_premium = false,
        public ?\DateTimeImmutable $scheduled_at = null,
        public ?File $thumbnail_file = null,
        public ?PodcastSeason $season = null,
        public ?File $audio_file = null,
    ) {
        Mapper::hydrate($this->episode, $this);
    }
}