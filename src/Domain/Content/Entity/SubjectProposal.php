<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Domain\Authentication\Entity\User;
use Domain\Content\ValueObject\SubjectProposalStatus;
use Domain\Shared\Entity\IdentityTrait;
use Domain\Shared\Entity\OwnerTrait;
use Domain\Shared\Entity\TimestampTrait;

/**
 * class SubjectProposal.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SubjectProposal
{
    use IdentityTrait;
    use TimestampTrait;
    use OwnerTrait;

    public ?string $subject;

    public int $votes_count = 0;

    public SubjectProposalStatus $status;

    public function __construct()
    {
        $this->status = SubjectProposalStatus::reviewing();
    }

    public static function create(User $owner, string $subject): self
    {
        return (new self())
            ->setOwner($owner)
            ->setSubject($subject)
            ->setVotesCount(0);
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getVotesCount(): int
    {
        return $this->votes_count;
    }

    public function setVotesCount(int $count): self
    {
        $this->votes_count = $count;

        return $this;
    }

    public function increaseVotesCount(int $votes = 1): self
    {
        $this->votes_count += $votes;

        return $this;
    }

    public function decreaseVotesCount(int $votes = 1): self
    {
        $this->votes_count -= $votes;

        return $this;
    }

    public function getStatus(): SubjectProposalStatus
    {
        return $this->status;
    }

    public function setStatus(SubjectProposalStatus|string $status): self
    {
        if ($status instanceof SubjectProposalStatus) {
            $this->status = $status;
        } else {
            $this->status = SubjectProposalStatus::fromString($status);
        }

        return $this;
    }
}
