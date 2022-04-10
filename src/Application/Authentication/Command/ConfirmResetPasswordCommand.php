<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\ResetPasswordToken;

/**
 * Class ConfirmResetPasswordCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ConfirmResetPasswordCommand
{
    public function __construct(
        public readonly ResetPasswordToken $token,
        public ?string $password = null
    ) {
    }
}
