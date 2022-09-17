<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * class DeleteUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteUserCommand
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
