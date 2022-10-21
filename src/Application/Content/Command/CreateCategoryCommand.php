<?php

declare(strict_types=1);

namespace Application\Content\Command;

/**
 * class CreateCategoryCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateCategoryCommand
{
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
    ) {
    }
}
