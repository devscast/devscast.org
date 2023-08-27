<?php

declare(strict_types=1);

namespace Application\Content\Command\Blog;

use Application\Content\Command\AbstractContentCommand;
use Domain\Content\Entity\Blog\Category;
use Domain\Content\Enum\ContentType;

/**
 * class CreatePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePostCommand extends AbstractContentCommand
{
    public function __construct(
        public ?Category $category = null,
        public ContentType $content_type = ContentType::POST
    ) {
    }
}
