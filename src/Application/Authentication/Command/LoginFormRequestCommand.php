<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class LoginFormRequestCommand
 * @package Application\Authentication\Command
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginFormRequestCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
