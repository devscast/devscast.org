<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\LoginAttempt;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\LoginAttemptRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * Class LoginAttemptRepositoryInterface.
 *
 * @extends AbstractRepository<LoginAttempt>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginAttemptRepository extends AbstractRepository implements LoginAttemptRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoginAttempt::class);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countRecentFor(User $user): int
    {
        return intval($this->createQueryBuilder('l')
            ->select('COUNT(l.id) as count')
            ->where('l.owner = :user')
            ->setParameter('user', $user)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult());
    }

    public function deleteAttemptsFor(User $user): void
    {
        $this->createQueryBuilder('a')
            ->where('a.owner = :user')
            ->setParameter('user', $user)
            ->delete()
            ->getQuery()
            ->execute();
    }
}
