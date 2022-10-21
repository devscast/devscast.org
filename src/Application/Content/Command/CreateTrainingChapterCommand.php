<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateTrainingChapterCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateTrainingChapterCommand
{
    public function __construct(
        #[Assert\NotBlank] public ?string $name = null,
        public ?string $slug = null,
        #[Assert\Length(min: 10)] public ?string $description = null,
        public Collection $videos = new ArrayCollection(),
        public int $order = 1
    ) {
    }
}
