<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\LoginAttempt;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\LoginAttemptRepositoryInterface;

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

    public function countRecentFor(User $user): int
    {
        return $this->count([
            'owner' => $user,
        ]);
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
