<?php

declare(strict_types=1);

namespace Domain\Content\Entity\Training;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Entity\Content;
use Domain\Content\Enum\ContentType;

/**
 * Class Video.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Video extends Content
{
    private ?string $source_url = null;

    private ?string $timecodes = null;

    /**
     * @var Collection<Technology>
     */
    private Collection $technologies;

    public function __construct()
    {
        parent::__construct();
        $this->technologies = new ArrayCollection();
    }

    public function getContentType(): ContentType
    {
        return ContentType::VIDEO;
    }

    public function getSourceUrl(): ?string
    {
        return $this->source_url;
    }

    public function setSourceUrl(?string $source_url): self
    {
        $this->source_url = $source_url;

        return $this;
    }

    public function getTimecodes(): ?string
    {
        return $this->timecodes;
    }

    public function setTimecodes(?string $timecodes): self
    {
        $this->timecodes = $timecodes;

        return $this;
    }

    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (! $this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }
}
