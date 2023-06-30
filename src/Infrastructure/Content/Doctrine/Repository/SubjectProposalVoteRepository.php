<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\SubjectProposal;
use Domain\Content\Entity\SubjectProposalVote;
use Domain\Content\Repository\SubjectProposalVoteRepositoryInterface;

/**
 * class SubjectProposalVoteRepository.
 *
 * @extends AbstractRepository<SubjectProposalVote>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SubjectProposalVoteRepository extends AbstractRepository implements SubjectProposalVoteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectProposalVote::class);
    }

    public function findVote(User $voter, SubjectProposal $proposal): ?SubjectProposalVote
    {
        /** @var SubjectProposalVote|null $result */
        $result = $this->findOneBy([
            'owner' => $voter,
            'proposal' => $proposal,
        ]);

        return $result;
    }
}
