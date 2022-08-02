<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\SubjectProposal;

/**
 * class ToggleSubjectProposalVoteCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ToggleSubjectProposalVoteCommand
{
    public function __construct(
        public readonly User $voter,
        public readonly SubjectProposal $proposal
    ) {
    }
}
