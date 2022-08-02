<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Authentication\Entity\User;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * class SubjectProposalVote.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SubjectProposalVote
{
    use IdentityTrait;
    use TimestampTrait;
    use OwnerTrait;

    private ?SubjectProposal $proposal;

    public static function create(User $voter, SubjectProposal $proposal): self
    {
        return (new self())
            ->setOwner($voter)
            ->setProposal($proposal);
    }

    public function getProposal(): ?SubjectProposal
    {
        return $this->proposal;
    }

    public function setProposal(?SubjectProposal $proposal): self
    {
        $this->proposal = $proposal;

        return $this;
    }
}
