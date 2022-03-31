<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class LoginLinkRequestCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginLinkRequestCommand
{
    public function __construct(
        public readonly string $email
    ) {
    }
}
