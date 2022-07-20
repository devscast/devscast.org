<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

/**
 * Class Video.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Video extends Content
{
    use AuthorTrait;

    private ?string $source_url = null;

    public function getSourceUrl(): ?string
    {
        return $this->source_url;
    }

    public function setSourceUrl(?string $source_url): self
    {
        $this->source_url = $source_url;

        return $this;
    }
}
