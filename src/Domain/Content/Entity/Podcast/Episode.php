<?php

declare(strict_types=1);

namespace Domain\Content\Entity\Podcast;

use Domain\Content\Entity\Content;
use Domain\Content\Enum\ContentType;
use Domain\Content\Enum\EpisodeType;
use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PodcastEpisode.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Episode extends Content
{
    private ?int $episode_number = null;

    private ?Season $season = null;

    private EpisodeType $episode_type = EpisodeType::FULL;

    private ?EmbeddedFile $audio;

    private ?File $audio_file = null;

    public function __construct()
    {
        parent::__construct();
        $this->audio = EmbeddedFile::default();
        $this->content_type = ContentType::PODCAST;
    }

    public function getContentType(): ContentType
    {
        return ContentType::PODCAST;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getEpisodeType(): EpisodeType
    {
        return $this->episode_type;
    }

    public function setEpisodeType(EpisodeType|string $episode_type): self
    {
        $this->episode_type = match (true) {
            $episode_type instanceof EpisodeType => $episode_type,
            default => EpisodeType::from($episode_type)
        };

        return $this;
    }

    public function getAudio(): ?EmbeddedFile
    {
        return $this->audio;
    }

    public function setAudio(?EmbeddedFile $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getAudioFile(): ?File
    {
        return $this->audio_file;
    }

    public function setAudioFile(?File $audio_file): self
    {
        $this->audio_file = $audio_file;
        if ($audio_file instanceof UploadedFile) {
            $this->setUpdatedAtWithCurrentTime();
        }

        return $this;
    }

    public function getEpisodeNumber(): ?int
    {
        return $this->episode_number;
    }

    public function setEpisodeNumber(?int $episode_number): self
    {
        $this->episode_number = $episode_number;

        return $this;
    }
}
