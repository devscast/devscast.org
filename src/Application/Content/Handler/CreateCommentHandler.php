<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateCommentCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateCommentCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateCommentHandler
{
    public function __invoke(CreateCommentCommand $command): void
    {
    }
}
