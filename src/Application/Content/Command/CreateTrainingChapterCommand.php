<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * class CreateTrainingChapterCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateTrainingChapterCommand
{
    public function __construct(
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $description = null,
        public array $videos = [],
        public int $order = 1
    ) {
    }

    public function setVideos(array|Collection $data): self
    {
        match (true) {
            $data instanceof Collection => $data->toArray(),
            default => new ArrayCollection($data)
        };

        return $this;
    }
}
