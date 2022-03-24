<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepository as UserRepositoryInterface;

/**
 * Class UserRepository
 * @package Infrastructure\Authentication\Repository
 * @author bernard-ng <bernard@devscast.tech>
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findForOauth(string $service, ?string $serviceId, ?string $email): ?User
    {
        if (null === $serviceId || null === $email) {
            return null;
        }

        try {
            /** @var User|null */
            return ($this->createQueryBuilder('u')
                ->where('u.email = :email')
                ->orWhere("u.{$service}_id = :serviceId")
                ->setMaxResults(1)
                ->setParameters([
                    'email' => $email,
                    'serviceId' => $serviceId,
                ])
                ->getQuery()
                ->getOneOrNullResult());
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
