<?php

declare(strict_types=1);

namespace Application\Content\Command\Training;

use Domain\Content\Entity\Training\Technology;

/**
 * class DeleteTechnologyCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class DeleteTechnologyCommand
{
    public function __construct(
        public Technology $_entity
    ) {
    }
}
