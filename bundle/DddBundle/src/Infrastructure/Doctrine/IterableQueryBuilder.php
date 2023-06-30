<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Doctrine;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Rend une requête iterable.
 *
 * Cette classe permet de passer des requêtes au template sans les exécuter en amont pour améliorer l'efficacité du cache.
 * La requête n'est pas exécuté avant la première itération
 *
 * @template E of object
 */
class IterableQueryBuilder extends QueryBuilder implements \IteratorAggregate, \ArrayAccess
{
    private bool $firstResultFetched = false;

    /**
     * @var E|null
     */
    private ?object $firstResult = null;

    /**
     * @var E[]|null
     */
    private ?array $results = null;

    /**
     * This will extract the first result from the query (without collecting the other elements).
     *
     * @return E|null
     *
     * @throws NonUniqueResultException
     */
    public function getFirstResultOnly(): ?object
    {
        if (false === $this->firstResultFetched) {
            $this->firstResultFetched = true;
            $this->firstResult = $this->getQuery()->setMaxResults(1)->getOneOrNullResult();
        }

        return $this->firstResult;
    }

    /**
     * @return E[]
     */
    public function getResults(): array
    {
        if (null === $this->results) {
            $this->results = $this->getQuery()->getResult();
        }

        return $this->results;
    }

    /**
     * @return \ArrayIterator<E>
     */
    public function getIterator(): \Traversable
    {
        if (null === $this->results) {
            $this->results = $this->getQuery()->getResult();
        }

        return new \ArrayIterator($this->results);
    }

    /**
     * @param string $offset
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->getResults());
    }

    /**
     * @param string $offset
     */
    public function offsetGet(mixed $offset): array|object
    {
        return $this->getResults()[$offset];
    }

    /**
     * @param string       $offset
     * @param object|array $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->getResults()[$offset] = $value;
    }

    /**
     * @param string $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->getResults()[$offset]);
    }
}
