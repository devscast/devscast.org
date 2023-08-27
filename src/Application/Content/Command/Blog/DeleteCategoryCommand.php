<?php

declare(strict_types=1);

namespace Application\Content\Command\Blog;

use Domain\Content\Entity\Blog\Category;

/**
 * class DeleteCategoryCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DeleteCategoryCommand
{
    public function __construct(
        public Category $_entity
    ) {
    }
}
