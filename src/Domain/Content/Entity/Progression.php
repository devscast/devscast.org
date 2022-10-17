<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * class Progression.
 * Allows you to save the playback progress of a content (podcast or video).
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Progression
{
    use IdentityTrait;
    use TimestampTrait;
    use OwnerTrait;

    private int $progress = 0;

    private ?Content $target = null;

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function setProgress(int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getTarget(): ?Content
    {
        return $this->target;
    }

    public function setTarget(?Content $target): self
    {
        $this->target = $target;

        return $this;
    }
}
