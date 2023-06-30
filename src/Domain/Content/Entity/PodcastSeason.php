<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Devscast\Bundle\DddBundle\Domain\Entity\ThumbnailTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\ValueObject\EmbeddedFile;

/**
 * Class PodcastSeason.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PodcastSeason extends AbstractEntity
{
    use ThumbnailTrait;

    private ?string $name = null;

    private ?string $short_code = null;

    private ?string $slug = null;

    private ?string $description = null;

    /**
     * @var Collection<PodcastEpisode>
     */
    private Collection $episodes;

    private int $episode_count = 0;

    public function __construct()
    {
        $this->thumbnail = EmbeddedFile::default();
        $this->episodes = new ArrayCollection();
    }

    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(PodcastEpisode $episode): self
    {
        if (! $this->episodes->contains($episode)) {
            $this->episodes->add($episode);
            $episode->setSeason($this);
            $this->episode_count = $this->episodes->count();
        }

        return $this;
    }

    public function removeEpisode(PodcastEpisode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            $this->episode_count = $this->episodes->count();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->short_code;
    }

    public function setShortCode(?string $short_code): self
    {
        $this->short_code = $short_code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
