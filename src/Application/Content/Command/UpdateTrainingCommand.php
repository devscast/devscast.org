<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Content\Entity\Training;

/**
 * class UpdateTrainingCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateTrainingCommand extends AbstractContentCommand
{
    public function __construct(
        public readonly Training $state,
        public ?string $youtube_playlist = null,
        public ?string $links = null,
    ) {
        Mapper::hydrate($this->state, $this);
    }
}
