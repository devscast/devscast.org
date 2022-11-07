<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Attachment;
use Domain\Content\Repository\AttachmentRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class AttachmentRepository.
 *
 * @extends AbstractRepository<Attachment>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AttachmentRepository extends AbstractRepository implements AttachmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attachment::class);
    }

    public function findYearsMonths(): array
    {
        /** @var array $rows */
        $rows = $this->createQueryBuilder('a')
            ->select('EXTRACT(MONTH FROM a.created_at) as month, EXTRACT(YEAR FROM a.created_at) as year, COUNT(a.id) as count')
            ->groupBy('month', 'year')
            ->orderBy('month', 'DESC')
            ->orderBy('year', 'DESC')
            ->getQuery()
            ->getResult();

        return array_map(function (array $row) {
            return [
                'path' => sprintf('%s/%s', $row['year'], str_pad((string) $row['month'], 2, '0', STR_PAD_LEFT)),
                'count' => $row['count'],
            ];
        }, $rows);
    }

    public function findForPath(string $path): array
    {
        $parts = explode('/', $path);
        $start = new \DateTimeImmutable("{$parts[0]}-{$parts[1]}-01");
        $end = $start->modify('+1 month -1 second');

        /** @var Attachment[] $result */
        $result = $this->createQueryBuilder('a')
            ->where('a.created_at BETWEEN :start AND :end')
            ->setParameters([
                'start' => $start,
                'end' => $end,
            ])
            ->orderBy('a.created_at', 'DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findLatest(): array
    {
        /** @var Attachment[] $result */
        $result = $this->createQueryBuilder('a')
            ->orderBy('a.created_at', 'DESC')
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function search(string $query): array
    {
        /** @var Attachment[] $result */
        $result = $this->createQueryBuilder('a')
            ->where('a.thumbnail.name LIKE :search')
            ->orderBy('a.created_at', 'DESC')
            ->setMaxResults(25)
            ->setParameter('search', "%${query}%")
            ->getQuery()
            ->getResult();

        return $result;
    }
}
