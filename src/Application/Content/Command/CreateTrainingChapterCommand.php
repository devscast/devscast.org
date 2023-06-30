<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Entity\Training;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateTrainingChapterCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateTrainingChapterCommand
{
    public function __construct(
        public ?Training $training = null,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        public ?string $description = null,
        public array $videos = [],
        #[Assert\GreaterThanOrEqual(1)] public int $order = 1
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
