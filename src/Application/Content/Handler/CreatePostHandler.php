<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePostCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePostHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePostHandler
{
    public function __invoke(CreatePostCommand $command): void
    {
    }
}
