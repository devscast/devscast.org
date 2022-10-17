<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreatePostListCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreatePostListHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreatePostListHandler
{
    public function __invoke(CreatePostListCommand $command): void
    {
    }
}
