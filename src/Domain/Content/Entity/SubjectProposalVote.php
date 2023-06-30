<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Devscast\Bundle\DddBundle\Domain\Entity\AbstractEntity;
use Domain\Authentication\Entity\User;
use Domain\Shared\Entity\OwnerTrait;

/**
 * class SubjectProposalVote.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SubjectProposalVote extends AbstractEntity
{
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
