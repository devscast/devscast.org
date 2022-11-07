<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * class EmailUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EmailUserCommand
{
    public function __construct(
        public readonly User $user,
        public ?string $subject = null,
        public ?string $message = null
    ) {
    }
}
