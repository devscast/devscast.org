<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class ToggleEmailAuthCodeCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ToggleEmailAuthCodeCommand
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
