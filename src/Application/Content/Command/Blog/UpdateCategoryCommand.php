<?php

declare(strict_types=1);

namespace Application\Content\Command\Blog;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Blog\Category;

/**
 * class UpdateCategoryCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateCategoryCommand
{
    public function __construct(
        public readonly Category $_entity,
        public ?string $name = null,
        public ?string $description = null
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
