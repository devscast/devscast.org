<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateCommentCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateCommentHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateCommentHandler
{
    public function __invoke(UpdateCommentCommand $command): void
    {
    }
}
