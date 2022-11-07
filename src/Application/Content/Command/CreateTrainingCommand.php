<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;

/**
 * class CreateTrainingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateTrainingCommand extends AbstractContentCommand
{
    public function __construct(
        public ?string $youtube_playlist = null,
        public ?string $links = null,
    ) {
        $this->content_type = ContentType::training();
        $this->status = ContentStatus::draft();
        $this->education_level = EducationLevel::beginner();
    }
}
