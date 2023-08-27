<?php

declare(strict_types=1);

namespace Application\Content\Command\Training;

use Application\Content\Command\AbstractContentCommand;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Authentication\Entity\User;
use Domain\Content\Enum\ContentType;

/**
 * class CreateVideoCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateVideoCommand extends AbstractContentCommand
{
    public function __construct(
        public ?User $owner = null,
        public ?string $source_url = null,
        public ?string $timecodes = null,
        public array $technologies = [],
        public ContentType $content_type = ContentType::VIDEO,
    ) {
    }

    public function setTechnologies(array|Collection $data): self
    {
        match (true) {
            $data instanceof Collection => $data->toArray(),
            default => new ArrayCollection($data)
        };

        return $this;
    }
}
