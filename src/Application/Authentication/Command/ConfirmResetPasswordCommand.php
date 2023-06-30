<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\ResetPasswordToken;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ConfirmResetPasswordCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ConfirmResetPasswordCommand
{
    public function __construct(
        public readonly ResetPasswordToken $token,
        #[Assert\NotBlank] #[Assert\Length(min: 6, max: 4096)] public ?string $password = null
    ) {
    }
}
