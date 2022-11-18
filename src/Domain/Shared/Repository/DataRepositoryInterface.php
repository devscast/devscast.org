<?php

declare(strict_types=1);

namespace Domain\Shared\Repository;

/**
 * Interface DataRepository.
 *
 * @template-covariant E of object
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface DataRepositoryInterface
{
    /**
     * @return array
     * @psalm-return array<E>
     */
    public function findAll();

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     * @psmal-return array<E>
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /**
     * @return object|null
     * @psmal-return E|null
     */
    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return object|null
     * @psmal-return E|null
     */
    public function find(mixed $id);

    public function save(object $entity): void;

    public function delete(object $entity): void;

    /**
     * @psmal-return E
     */
    public function findOrFail(int|string $id): object;

    /**
     * @psalm-return E
     */
    public function findOneByCaseInsensitive(array $conditions): ?object;

    /**
     * @psalm-return array<E>
     */
    public function findByCaseInsensitive(array $conditions): array;
}
