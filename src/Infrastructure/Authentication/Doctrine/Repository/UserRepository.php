<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Class UserRepositoryInterface.
 *
 * @extends AbstractRepository<User>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserRepository extends AbstractRepository implements UserRepositoryInterface, PasswordUpgraderInterface
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
            /** @var User|null $result */
            $result = $this->createQueryBuilder('u')
                ->where('u.email = :email')
                ->orWhere("u.{$service}_id = :serviceId")
                ->setMaxResults(1)
                ->setParameters([
                    'email' => $email,
                    'serviceId' => $serviceId,
                ])
                ->getQuery()
                ->getOneOrNullResult();

            return $result;
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findOneByEmail(string $email): ?User
    {
        try {
            /** @var User|null $result */
            $result = $this->createQueryBuilder('u')
                ->where('u.email = :email')
                ->setParameter('email', $email)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            return $result;
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findOneByUsername(string $username): ?User
    {
        try {
            /** @var User|null $result */
            $result = $this->createQueryBuilder('u')
                ->where('u.username.username = :username')
                ->setParameter('username', $username)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            return $result;
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findOneByEmailOrUsername(string $emailOrUsername): ?User
    {
        try {
            /** @var User|null $result */
            $result = $this->createQueryBuilder('u')
                ->where('LOWER(u.email) = :identifier')
                ->orWhere('LOWER(u.username.username) = :identifier')
                ->setParameter('identifier', mb_strtolower($emailOrUsername))
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            return $result;
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface|User $user, string $newHashedPassword): void
    {
        if (! $user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->save($user);
    }
}
