<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\Entity\AbstractEntity;
use Domain\Shared\Entity\ThumbnailTrait;
use Domain\Shared\Entity\UuidTrait;
use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\Uid\Uuid;

/**
 * class Technology.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Technology extends AbstractEntity
{
    use ThumbnailTrait;
    use UuidTrait;

    private ?string $name = null;

    private ?string $slug = null;

    private ?string $description = null;

    private int $content_count = 0;

    /**
     * @var Collection<Content>
     */
    private Collection $contents;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->thumbnail = EmbeddedFile::default();
        $this->contents = new ArrayCollection();
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

    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (! $this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->addTechnology($this);
            $this->content_count = $this->contents->count();
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->removeElement($content)) {
            $content->removeTechnology($this);
            $this->content_count = $this->contents->count();
        }

        return $this;
    }

    public function getContentCount(): int
    {
        return $this->content_count;
    }

    public function setContentCount(int $content_count): self
    {
        $this->content_count = $content_count;

        return $this;
    }
}
