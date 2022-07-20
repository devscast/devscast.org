<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Content\ValueObject\PodcastEpisodeAudio;
use Domain\Content\ValueObject\PodcastEpisodeType;

/**
 * Class PodcastEpisode.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PodcastEpisode extends Content
{
    private ?PodcastSeason $season = null;

    private PodcastEpisodeType $episode_type;

    private PodcastEpisodeAudio $audio;

    public function __construct()
    {
        parent::__construct();
        $this->episode_type = PodcastEpisodeType::full();
        $this->audio = PodcastEpisodeAudio::default();
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

    public function getAudio(): PodcastEpisodeAudio
    {
        return $this->audio;
    }

    public function setAudio(PodcastEpisodeAudio $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getEpisodeType(): PodcastEpisodeType
    {
        return $this->episode_type;
    }

    public function setEpisodeType(PodcastEpisodeType|string $episode_type): self
    {
        if ($episode_type instanceof PodcastEpisodeType) {
            $this->episode_type = $episode_type;
        } else {
            $this->episode_type = PodcastEpisodeType::fromString($episode_type);
        }

        return $this;
    }
}
