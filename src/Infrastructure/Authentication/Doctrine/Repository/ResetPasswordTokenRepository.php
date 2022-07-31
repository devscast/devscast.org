<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\ResetPasswordTokenRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * Class ResetPasswordTokenRepositoryInterface.
 *
 * @extends AbstractRepository<ResetPasswordToken>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordTokenRepository extends AbstractRepository implements ResetPasswordTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordToken::class);
    }

    public function findFor(User $user): ?ResetPasswordToken
    {
        try {
            /** @var ResetPasswordToken|null $result */
            $result = $this->createQueryBuilder('r')
                ->where('r.user = :user')
                ->setParameter('user', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            return $result;
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findOneByToken(string $token): ?ResetPasswordToken
    {
        try {
            /** @var ResetPasswordToken|null $result */
            $result = $this->createQueryBuilder('r')
                ->where('r.token = :token')
                ->setParameter('token', $token)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            return $result;
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function clean(): int
    {
        return intval($this->createQueryBuilder('r')
            ->where('r.created_at < :date')
            ->setParameter('date', new \DateTimeImmutable('-3 month'))
            ->delete(ResetPasswordToken::class, 'r')
            ->getQuery()
            ->execute());
    }
}
