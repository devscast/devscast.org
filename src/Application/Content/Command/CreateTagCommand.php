<?php

declare(strict_types=1);

namespace Application\Content\Command;

/**
 * class CreateTagCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateTagCommand
{
    public function __construct(
        public ?string $name = null
    ) {
    }
}
