<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;

/**
 * Class DisconnectOAuthServiceCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DisconnectOAuthServiceCommand
{
    public function __construct(
        public readonly User $user,
        public readonly string $service
    ) {
    }
}
