<?php

declare(strict_types=1);

namespace Domain\Shared\Repository;

/**
 * Interface DataRepository.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface DataRepository
{
    public function save(object $entity): void;

    public function delete(object $entity): void;

    public function findOrFail(int|string $id): object;

    public function findOneByCaseInsensitive(array $conditions): ?object;

    public function findByCaseInsensitive(array $conditions): array;
}
