<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Doctrine\Repository;

/**
 * Trait NativeQueryTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait NativeQueryTrait
{
    public function execute(string $sql, array $data, bool $fetchAll = true): array
    {
        try {
            $connection = $this->_em->getConnection();
            $statement = $connection->prepare($sql);
            $result = $statement->executeQuery($data);

            if ($fetchAll) {
                return $result->fetchAllAssociative();
            }
            $data = $result->fetchAssociative();

            return false === $data ? [] : $data;
        } catch (\Throwable) {
            return [];
        }
    }
}
