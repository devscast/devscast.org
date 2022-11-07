<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Category;
use Domain\Content\Entity\PostSeries;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;

/**
 * class CreatePostCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreatePostCommand extends AbstractContentCommand
{
    public function __construct(
        public ?Category $category = null,
        public ?PostSeries $series = null,
    ) {
        $this->content_type = ContentType::post();
        $this->status = ContentStatus::draft();
        $this->education_level = EducationLevel::beginner();
    }
}
