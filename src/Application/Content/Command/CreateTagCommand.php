<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateTagCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateTagCommand
{
    public function __construct(
        #[Assert\NotBlank] public ?string $name = null
    ) {
    }
}
