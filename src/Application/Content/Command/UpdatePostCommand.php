<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Category;
use Domain\Content\Entity\Post;
use Domain\Content\Entity\PostSeries;
use Domain\Content\ValueObject\ContentType;

/**
 * class UpdatePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePostCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly Post $state,
        public ?Category $category = null,
        public ?PostSeries $series = null,
    ) {
        $this->content_type = ContentType::post();
        Mapper::hydrate($this->state, $this, ['content_type']);
    }
}
