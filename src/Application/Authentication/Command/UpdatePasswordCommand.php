<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdatePasswordCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdatePasswordCommand
{
    public function __construct(
        public readonly User $user,
        public ?string $current = null,
        #[Assert\NotBlank]
        #[Assert\Length(min: 6, max: 4096)]
        public ?string $new = null
    ) {
    }
}
