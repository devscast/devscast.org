<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository;

/**
 * Trait NativeQueryTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait NativeQueryTrait
{
    public function execute(string $sql, array $data = []): object
    {
        $connection = $this->getEntityManager()->getConnection();
        $statement = $connection->prepare($sql);

        return $statement->executeQuery($data);
    }

    private function calculateProgressionRatio(float|int $previous, float|int $current): int|float
    {
        return 0.0 === $previous || 0 === $previous ?
            $current * 100 :
            round(($current - $previous) * ($previous / 100), 2);
    }

    private function createDateTimeInterval(string $start, string $end, string $format = 'Y-m-d'): array
    {
        try {
            return [
                (new \DateTimeImmutable($start))->format($format),
                (new \DateTimeImmutable($end))->format($format),
            ];
        } catch (\Throwable) {
            return [];
        }
    }

    private function createMonthSumSQL(string $date): string
    {
        return <<< SQL
            IFNULL(SUM(MONTH({$date}) = 1), 0) AS 'Jan',
            IFNULL(SUM(MONTH({$date}) = 2), 0) AS 'Feb',
            IFNULL(SUM(MONTH({$date}) = 3), 0) AS 'Mar',
            IFNULL(SUM(MONTH({$date}) = 4), 0) AS 'Apr',
            IFNULL(SUM(MONTH({$date}) = 5), 0) AS 'May',
            IFNULL(SUM(MONTH({$date}) = 6), 0) AS 'Jun',
            IFNULL(SUM(MONTH({$date}) = 7), 0) AS 'Jul',
            IFNULL(SUM(MONTH({$date}) = 8), 0) AS 'Aug',
            IFNULL(SUM(MONTH({$date}) = 9), 0) AS 'Sep',
            IFNULL(SUM(MONTH({$date}) = 10), 0) AS 'Oct',
            IFNULL(SUM(MONTH({$date}) = 11), 0) AS 'Nov',
            IFNULL(SUM(MONTH({$date}) = 12), 0) AS 'Dec'
        SQL;
    }
}
