<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * class TrainingChapter.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class TrainingChapter
{
    use IdentityTrait;
    use TimestampTrait;

    /**
     * @var Collection<Video>
     */
    public Collection $videos;

    private ?string $name = null;

    private ?string $description = null;

    private ?string $slug = null;

    private int $order = 1;

    private ?Training $training = null;

    public function __construct()
    {
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

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

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
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        $this->videos->removeElement($video);

        return $this;
    }
}
