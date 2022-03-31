<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class RequestLoginLinkCommand
 * @package Application\Authentication\Command
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RequestLoginLinkCommand
{
    public function __construct(
        public readonly string $email
    ) {
    }
}
