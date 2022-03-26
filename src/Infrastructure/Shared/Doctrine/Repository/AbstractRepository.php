<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Shared\Repository\DataRepository;

/**
 * @template E of object
 *
 * @method E|null find(mixed $id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method E|null findOneBy(array $criteria, array $orderBy = null)
 * @method E[]    findAll()
 * @method E[]    findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 */
abstract class AbstractRepository extends ServiceEntityRepository implements DataRepository
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
     * @return E
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

    public function findByCaseInsensitive(array $conditions): array
    {
        return (array) $this->findByCaseInsensitiveQuery($conditions)->getResult();
    }

    /**
     * @return E|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneByCaseInsensitive(array $conditions): ?object
    {
        /** @var E|null $result */
        $result = $this->findByCaseInsensitiveQuery($conditions)->setMaxResults(1)->getOneOrNullResult();

        return $result;
    }

    /**
     * @psalm-param E $entity
     */
    public function save(object $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @psalm-param E $entity
     */
    public function delete(object $entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
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
