<?php

declare(strict_types=1);

namespace Domain\Content\Entity\Training;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Devscast\Bundle\DddBundle\Domain\Entity\ThumbnailTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\ValueObject\EmbeddedFile;

/**
 * class Technology.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Technology extends AbstractEntity
{
    use ThumbnailTrait;

    private ?string $name = null;
    private ?string $slug = null;
    private ?string $description = null;
    private int $video_count = 0;

    /**
     * @var Collection<Video>
     */
    private Collection $videos;

    public function __construct()
    {
        $this->thumbnail = EmbeddedFile::default();
        $this->videos = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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

    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (! $this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->addTechnology($this);
            $this->video_count = $this->videos->count();
        }

        return $this;
    }

    public function removeContent(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            $video->removeTechnology($this);
            $this->video_count = $this->videos->count();
        }

        return $this;
    }

    public function getVideoCount(): int
    {
        return $this->video_count;
    }

    public function setVideoCount(int $video_count): self
    {
        $this->video_count = $video_count;

        return $this;
    }
}
