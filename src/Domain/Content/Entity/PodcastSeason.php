<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\ValueObject\Thumbnail;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * Class PodcastSeason.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PodcastSeason
{
    use IdentityTrait;
    use TimestampTrait;

    private ?string $name = null;

    private ?string $short_code = null;

    private ?string $description = null;

    /**
     * @var Collection<PodcastEpisode>
     */
    private Collection $episodes;

    private int $episode_count = 0;

    private Thumbnail $thumbnail;

    public function __construct()
    {
        $this->thumbnail = Thumbnail::default();
        $this->episodes = new ArrayCollection();
    }

    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(PodcastEpisode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes->add($episode);
            $episode->setSeason($this);
        }

        return $this;
    }

    public function getEpisodeCount(): int
    {
        return $this->episode_count;
    }

    public function setEpisodeCount(int $episode_count): self
    {
        $this->episode_count = $episode_count;

        return $this;
    }

    public function getThumbnail(): Thumbnail
    {
        return $this->thumbnail;
    }

    public function setThumbnail(Thumbnail $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): PodcastSeason
    {
        $this->name = $name;
        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->short_code;
    }

    public function setShortCode(?string $short_code): PodcastSeason
    {
        $this->short_code = $short_code;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): PodcastSeason
    {
        $this->description = $description;
        return $this;
    }
}
