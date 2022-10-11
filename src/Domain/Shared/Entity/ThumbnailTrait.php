<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

use Domain\Shared\ValueObject\EmbeddedFile;

trait ThumbnailTrait
{
    private EmbeddedFile $thumbnail;

    public function getThumbnail(): EmbeddedFile
    {
        return $this->thumbnail;
    }

    public function setThumbnail(EmbeddedFile $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
