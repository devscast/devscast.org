<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\SubjectProposal;
use Domain\Content\Entity\SubjectProposalVote;

/**
 * Interface SubjectProposalVoteRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface SubjectProposalVoteRepositoryInterface extends DataRepositoryInterface
{
    public function findVote(User $voter, SubjectProposal $proposal): ?SubjectProposalVote;
}
