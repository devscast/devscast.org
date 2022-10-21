<?php

declare(strict_types=1);

namespace Application\Content\Handler;

use Application\Content\Command\UpVoteRatingCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class UpdateRatingCommandHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class UpVoteRatingHandler
{
    public function __invoke(UpVoteRatingCommand $command): void
    {
    }
}
