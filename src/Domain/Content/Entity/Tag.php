<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * Class Tag.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Tag
{
    use IdentityTrait;
    use TimestampTrait;

    private ?string $name = null;

    /**
     * @var Collection<Content>
     */
    private Collection $contents;

    public function __construct()
    {
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

    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (! $this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->addTag($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->removeElement($content)) {
            $content->removeTag($this);
        }

        return $this;
    }
}
