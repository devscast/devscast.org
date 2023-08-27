<?php

declare(strict_types=1);

namespace Domain\Content\Entity\Podcast;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Domain\Shared\Entity\OwnerTrait;

/**
 * class Progression.
 * Allows you to save the playback progress of a content (podcast or video).
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Progression extends AbstractEntity
{
    use OwnerTrait;

    private int $progress = 0;

    private ?Episode $target = null;

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function setProgress(int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getTarget(): ?Episode
    {
        return $this->target;
    }

    public function setTarget(?Episode $target): self
    {
        $this->target = $target;

        return $this;
    }
}
