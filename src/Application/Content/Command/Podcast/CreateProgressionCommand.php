<?php

declare(strict_types=1);

namespace Application\Content\Command\Podcast;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateProgressionCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateProgressionCommand
{
    public function __construct(
        public ?User $owner = null,
        public ?Content $target = null,
        #[Assert\GreaterThanOrEqual(0)] public int $progress = 0
    ) {
    }
}
