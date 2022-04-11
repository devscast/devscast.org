<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class ExportBackupCodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ExportBackupCodeCommand
{
    public function __construct(
        public readonly User $user,
    ) {
    }
}
