<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\TrainingChapter;

/**
 * class DeleteTrainingChapterCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteTrainingChapterCommand
{
    public function __construct(
        public readonly TrainingChapter $chapter
    ) {
    }
}
