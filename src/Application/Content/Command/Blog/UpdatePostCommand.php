<?php

declare(strict_types=1);

namespace Application\Content\Command\Blog;

use Application\Content\Command\AbstractContentCommand;
use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Blog\Category;
use Domain\Content\Entity\Blog\Post;
use Domain\Content\Enum\ContentType;

/**
 * class UpdatePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly Post $_entity,
        public ?Category $category = null,
        public ContentType $content_type = ContentType::POST,
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
