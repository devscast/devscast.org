<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Domain\Entity;

use Domain\Shared\ValueObject\EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * trait ThumbnailTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait ThumbnailTrait
{
    use TimestampTrait;

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

    public function setThumbnailFile(?File $thumbnail_file): self
    {
        $this->thumbnail_file = $thumbnail_file;
        if ($thumbnail_file instanceof UploadedFile) {
            $this->setUpdatedAtWithCurrentTime();
        }

        return $this;
    }
}
