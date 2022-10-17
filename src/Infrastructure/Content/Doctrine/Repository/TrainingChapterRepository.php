<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\TrainingChapter;
use Domain\Content\Repository\TrainingChapterRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class TrainingChapterRepository.
 *
 * @extends AbstractRepository<TrainingChapter>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TrainingChapterRepository extends AbstractRepository implements TrainingChapterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingChapter::class);
    }
}
