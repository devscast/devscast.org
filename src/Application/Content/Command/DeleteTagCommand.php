<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Content\Entity\Tag;

/**
 * class DeleteTagCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteTagCommand
{
    public function __construct(
        public readonly Tag $tag
    ) {
    }
}
