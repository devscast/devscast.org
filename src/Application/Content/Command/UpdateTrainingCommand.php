<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Content\Entity\Training;

/**
 * class UpdateTrainingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTrainingCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly Training $_entity,
        public ?string $youtube_playlist = null,
        public ?string $links = null,
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
