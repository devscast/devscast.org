<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ConfirmRegistrationCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class ConfirmRegistrationHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ConfirmRegistrationHandler
{
    public function __invoke(ConfirmRegistrationCommand $command): void
    {
    }
}
