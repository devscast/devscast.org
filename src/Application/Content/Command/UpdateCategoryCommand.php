<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Category;

/**
 * class UpdateCategoryCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCategoryCommand
{
    public function __construct(
        public readonly Category $category,
        public ?string $name = null,
        public ?string $description = null
    ) {
        Mapper::hydrate($this->category, $this);
    }
}
