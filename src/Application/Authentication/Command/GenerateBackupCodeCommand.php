<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class GenerateBackupCodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GenerateBackupCodeCommand
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
