<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

final class Toggle2FACommand
{
    public function __construct(
        public readonly User $user,
        public bool $google = false,
        public bool $email = false,
    ) {
        $this->google = $user->isGoogleAuthenticatorEnabled();
        $this->email = $user->isEmailAuthEnabled();
    }
}
