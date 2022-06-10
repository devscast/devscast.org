<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RequestLoginLinkCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RequestLoginLinkCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $email = null
    ) {
    }
}
