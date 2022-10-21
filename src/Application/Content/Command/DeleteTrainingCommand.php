<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Training;

/**
 * class DeleteTrainingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteTrainingCommand
{
    public function __construct(
        public readonly Training $training
    ) {
    }
}
