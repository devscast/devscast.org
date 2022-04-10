<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class RequestResetPasswordCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RequestResetPasswordCommand
{
    public function __construct(
        public ?string $email = null
    ) {
    }
}
