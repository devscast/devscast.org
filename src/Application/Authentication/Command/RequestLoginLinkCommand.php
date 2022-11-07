<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

/**
 * Class RequestLoginLinkCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RequestLoginLinkCommand
{
    public function __construct(
        public ?string $email = null
    ) {
    }
}
