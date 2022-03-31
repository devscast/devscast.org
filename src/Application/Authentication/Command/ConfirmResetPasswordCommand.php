<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class ConfirmResetPasswordCommand
 * @package Application\Authentication\Command
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ConfirmResetPasswordCommand
{
    public function __construct(
        public readonly string $password
    ) {
    }
}
