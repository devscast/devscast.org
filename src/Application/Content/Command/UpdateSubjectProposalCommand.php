<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Mapper;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\SubjectProposal;
use Domain\Content\ValueObject\SubjectProposalStatus;

/**
 * class UpdateSubjectProposalCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateSubjectProposalCommand
{
    public function __construct(
        public readonly User $owner,
        public readonly SubjectProposal $state,
        public ?string $subject = null,
        public ?SubjectProposalStatus $status = null
    ) {
        Mapper::hydrate($this->state, $this, ['owner']);
    }
}
