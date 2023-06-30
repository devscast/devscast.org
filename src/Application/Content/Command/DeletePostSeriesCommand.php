<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\PostSeries;

/**
 * class DeletePostSeriesCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeletePostSeriesCommand
{
    public function __construct(
        public readonly PostSeries $_entity
    ) {
    }
}
