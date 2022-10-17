<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DeleteCategoryCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class DeleteCategoryCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DeleteCategoryHandler
{
    public function __invoke(DeleteCategoryCommand $command): void
    {
    }
}
