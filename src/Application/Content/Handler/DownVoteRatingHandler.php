<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\DownVoteRatingCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateRatingCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class DownVoteRatingHandler
{
    public function __invoke(DownVoteRatingCommand $command): void
    {
    }
}
