<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Technology;
use Symfony\Component\HttpFoundation\File\File;

/**
 * class UpdateTechnologyCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTechnologyCommand
{
    public function __construct(
        public readonly Technology $state,
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?File $thumbnail_file = null,
    ) {
        Mapper::hydrate($this->state, $this);
    }
}
