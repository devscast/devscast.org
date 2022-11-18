<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Shared\Entity\AbstractEntity;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\ThumbnailTrait;
use Domain\Shared\ValueObject\EmbeddedFile;

/**
 * class Attachment.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Attachment extends AbstractEntity
{
    use OwnerTrait;
    use ThumbnailTrait;

    public function __construct()
    {
        $this->thumbnail = EmbeddedFile::default();
    }
}
