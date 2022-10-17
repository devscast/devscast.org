<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpdateCategoryCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateCategoryHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpdateCategoryHandler
{
    public function __invoke(UpdateCategoryCommand $command): void
    {
    }
}
