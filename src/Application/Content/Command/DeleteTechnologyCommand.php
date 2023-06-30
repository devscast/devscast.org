<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Technology;

/**
 * class DeleteTechnologyCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteTechnologyCommand
{
    public function __construct(
        public readonly Technology $_entity
    ) {
    }
}
