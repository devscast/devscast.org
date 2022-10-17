<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\CreateCategoryCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class CreateCategoryHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class CreateCategoryHandler
{
    public function __invoke(CreateCategoryCommand $command): void
    {
    }
}
