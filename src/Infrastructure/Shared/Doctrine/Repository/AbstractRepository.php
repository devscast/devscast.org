<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace Infrastructure\Shared\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * @template E of object
 */
abstract class AbstractRepository extends ServiceEntityRepository implements DataRepositoryInterface
{
    /**
     * @psalm-param class-string<E> $entityClass
     */
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * Trouve une entité par sa clef primaire et renvoie une exception en cas d'absence.
     *
     * @psmal-return E
     *
     * @throws EntityNotFoundException
     */
    public function findOrFail(int|string $id): object
    {
        $entity = $this->find($id, null, null);
        if (null === $entity) {
            throw EntityNotFoundException::fromClassNameAndIdentifier($this->_entityName, [(string) $id]);
        }

        return $entity;
    }

    /**
     * @psmal-return E[]
     */
    public function findByCaseInsensitive(array $conditions): array
    {
        /** @var E[] $result */
        $result = $this->findByCaseInsensitiveQuery($conditions)->getResult();

        return $result;
    }

    /**
     * @psmal-return E|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneByCaseInsensitive(array $conditions): ?object
    {
        /** @var E|null $result */
        $result = $this->findByCaseInsensitiveQuery($conditions)
            ->setMaxResults(1)
            ->getOneOrNullResult();

        return $result;
    }

    /**
     * @psalm-param E $entity
     */
    public function save(object $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @psalm-param E $entity
     */
    public function delete(object $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    protected function findByCaseInsensitiveQuery(array $conditions): Query
    {
        $conditionString = [];
        $parameters = [];
        foreach ($conditions as $k => $v) {
            $conditionString[] = "LOWER(o.${k}) = :${k}";
            $parameters[$k] = strtolower($v);
        }

        return $this->createQueryBuilder('o')
            ->where(join(' AND ', $conditionString))
            ->setParameters($parameters)
            ->getQuery();
    }
}
