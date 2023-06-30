<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class EmailUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EmailUserCommand
{
    public function __construct(
        public readonly User $user,
        #[Assert\NotBlank] public ?string $subject = null,
        #[Assert\NotBlank] public ?string $message = null
    ) {
    }
}
