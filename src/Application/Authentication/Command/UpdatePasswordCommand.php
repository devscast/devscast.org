<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * class UpdatePasswordCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePasswordCommand
{
    public function __construct(
        public readonly User $user,
        public ?string $current = null,
        public ?string $new = null
    ) {
    }
}
