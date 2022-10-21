<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\Entity\TrainingChapter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdateTrainingChapterCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTrainingChapterCommand
{
    public function __construct(
        public readonly TrainingChapter $chapter,
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\Length(min: 10)] public ?string $description = null,
        public Collection $videos = new ArrayCollection(),
        public int $order = 1
    ) {
        Mapper::hydrate($this->chapter, $this);
    }
}
