<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class ToggleGoogleAuthenticatorCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ToggleGoogleAuthenticatorCommand
{
    public function __construct(
        public readonly User $user
    ) {
    }
}
