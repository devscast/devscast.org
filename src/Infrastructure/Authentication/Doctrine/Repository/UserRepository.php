<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepository as UserRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Class UserRepository.
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
            /** @var User|null */
            return $this->createQueryBuilder('u')
                ->where('u.email = :email')
                ->orWhere("u.{$service}_id = :serviceId")
                ->setMaxResults(1)
                ->setParameters([
                    'email' => $email,
                    'serviceId' => $serviceId,
                ])
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findOneByEmail(string $email): ?User
    {
        /** @var User/null $user */
        $user = $this->findOneBy(['email' => $email]);
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->save($user);
    }
}
