<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * class ConfirmRegistrationCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ConfirmRegistrationCommand
{
    public function __construct(
        public readonly string $token
    ) {
    }
}
