<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LoginFormRequestCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginFormRequestCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $identifier = null,

        #[Assert\NotBlank]
        #[Assert\NotCompromisedPassword]
        #[Assert\Length(min: 6, max: 4096)]
        public ?string $password = null
    ) {
    }
}
