<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class RegenerateBackupCodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RegenerateBackupCodeCommand
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
