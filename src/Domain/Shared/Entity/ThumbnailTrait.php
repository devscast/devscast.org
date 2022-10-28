<?php

declare(strict_types=1);

namespace Domain\Shared\Entity;

use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait ThumbnailTrait
{
    protected EmbeddedFile $thumbnail;

    protected ?File $thumbnail_file = null;

    public function getThumbnail(): EmbeddedFile
    {
        return $this->thumbnail;
    }

    public function setThumbnail(EmbeddedFile $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getThumbnailFile(): ?File
    {
        return $this->thumbnail_file;
    }

    public function setThumbnailFile(?File $avatar_file): self
    {
        $this->thumbnail_file = $avatar_file;
        if ($avatar_file instanceof UploadedFile) {
            $this->setUpdatedAtWithCurrentTime();
        }

        return $this;
    }
}
