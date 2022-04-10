<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class ConnectOAuthServiceCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ConnectOAuthServiceCommand
{
    public function __construct(
        public readonly string $service
    ) {
    }
}
