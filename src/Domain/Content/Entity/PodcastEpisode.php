<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\PodcastEpisodeType;
use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PodcastEpisode.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PodcastEpisode extends Content
{
    private ?int $episode_number = null;

    private ?PodcastSeason $season = null;

    private PodcastEpisodeType $episode_type;

    private ?EmbeddedFile $audio;

    private ?File $audio_file = null;

    public function __construct()
    {
        parent::__construct();
        $this->episode_type = PodcastEpisodeType::full();
        $this->audio = EmbeddedFile::default();
        $this->content_type = ContentType::podcast();
    }

    public function getContentType(): ContentType
    {
        return ContentType::podcast();
    }

    public function getSeason(): ?PodcastSeason
    {
        return $this->season;
    }

    public function setSeason(?PodcastSeason $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getEpisodeType(): PodcastEpisodeType
    {
        return $this->episode_type;
    }

    public function setEpisodeType(PodcastEpisodeType|string $episode_type): self
    {
        $this->episode_type = match (true) {
            $episode_type instanceof PodcastEpisodeType => $episode_type,
            default => PodcastEpisodeType::fromString($episode_type)
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
