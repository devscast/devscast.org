<?php

declare(strict_types=1);

namespace Application\Content\Command\Blog;

use Domain\Content\Entity\Blog\Post;

/**
 * class DeletePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DeletePostCommand
{
    public function __construct(
        public Post $_entity
    ) {
    }
}
