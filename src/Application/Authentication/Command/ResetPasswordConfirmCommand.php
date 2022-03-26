<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class ResetPasswordConfirmData.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordConfirmCommand
{
    public function __construct(
        public readonly string $password
    ) {
    }
}
