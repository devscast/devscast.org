<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Training;
use Domain\Content\Entity\Video;

/**
 * class UpdateVideoCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateVideoCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly Video $_entity,
        public ?string $source_url = null,
        public ?string $timecodes = null,
        public ?Training $training = null,
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
