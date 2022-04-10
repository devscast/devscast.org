<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class CreateBasicUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateBasicUserCommand
{
    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly string $password,
        public readonly bool $is_admin = false
    ) {
    }
}
