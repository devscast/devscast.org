<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Training;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;

/**
 * class CreateVideoCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateVideoCommand extends AbstractContentCommand
{
    public function __construct(
        public ?User $owner = null,
        public ?string $source_url = null,
        public ?string $timecodes = null,
        public ?Training $training = null,
    ) {
        $this->content_type = ContentType::video();
        $this->status = ContentStatus::draft();
        $this->education_level = EducationLevel::beginner();
    }
}
