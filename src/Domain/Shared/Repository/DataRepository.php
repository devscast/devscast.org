<?php

declare(strict_types=1);

namespace Domain\Shared\Repository;

/**
 * Interface DataRepository
 * @package Domain\Shared\Repository
 * @author bernard-ng <bernard@devscast.tech>
 */
interface DataRepository
{
    public function find(mixed $id, ?int $lockMode = null, ?int $lockVersion = null): ?object;

    public function findOneBy(array $criteria, array $orderBy = null): ?object;

    public function findAll(): array;

    public function findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    public function count(array $criteria): int;
}
