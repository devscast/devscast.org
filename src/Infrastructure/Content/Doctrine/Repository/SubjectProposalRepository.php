<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Content\Entity\SubjectProposal;
use Domain\Content\Repository\SubjectProposalRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class SubjectProposalRepository.
 *
 * @extends AbstractRepository<SubjectProposal>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SubjectProposalRepository extends AbstractRepository implements SubjectProposalRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectProposal::class);
    }

    public function countRecentFor(User $owner): int
    {
        try {
            /** @var int $result */
            $result = $this->createQueryBuilder('sp')
                ->select('COUNT(sp.id)')
                ->where('sp.owner = :owner')
                ->andWhere('sp.created_at > :date')
                ->setParameters([
                    'owner' => $owner->getId(),
                    'date' => new \DateTimeImmutable('-1 month'),
                ])
                ->getQuery()
                ->getSingleScalarResult();
        } catch (\Throwable) {
            return 0;
        }

        return $result;
    }
}
