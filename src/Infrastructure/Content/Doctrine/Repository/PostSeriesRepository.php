<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\PostSeries;
use Domain\Content\Repository\PostSeriesRepositoryInterface;

/**
 * class PostSeriesRepository.
 *
 * @extends AbstractRepository<PostSeries>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PostSeriesRepository extends AbstractRepository implements PostSeriesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostSeries::class);
    }
}
