<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * class ResetLoginAttemptsCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetLoginAttemptsCommand
{
    public function __construct(
        public readonly string $token
    ) {
    }
}
