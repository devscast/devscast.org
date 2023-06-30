<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
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
        public readonly SubjectProposal $_entity,
        public ?string $subject = null,
        public ?SubjectProposalStatus $status = null
    ) {
        Mapper::hydrate($this->_entity, $this, ['owner']);
    }
}
