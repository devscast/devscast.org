<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RequestResetPasswordCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RequestResetPasswordCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $email = null
    ) {
    }
}
