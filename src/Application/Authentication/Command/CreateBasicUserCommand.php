<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateBasicUserCommand
 * @package Application\Authentication\Command
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateBasicUserCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $username,

        #[Assert\NotBlank]
        #[Assert\Email]
        public readonly string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6, max: 4096)]
        public readonly string $password,
        public readonly bool $is_admin = false
    ) {
    }
}
