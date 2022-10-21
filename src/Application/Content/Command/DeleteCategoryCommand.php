<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Category;

/**
 * class DeleteCategoryCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteCategoryCommand
{
    public function __construct(
        public readonly Category $category
    ) {
    }
}
