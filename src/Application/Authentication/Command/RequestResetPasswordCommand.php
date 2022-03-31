<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class ResetPasswordRequestCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordRequestCommand
{
    public function __construct(
        public readonly string $email
    ) {
    }
}
