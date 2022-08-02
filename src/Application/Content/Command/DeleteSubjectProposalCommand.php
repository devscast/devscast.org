<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\SubjectProposal;

/**
 * class DeleteSubjectProposalCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DeleteSubjectProposalCommand
{
    public function __construct(
        public readonly User $owner,
        public readonly SubjectProposal $proposal
    ) {
    }
}
