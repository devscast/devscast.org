<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Training;
use Domain\Content\Repository\TrainingRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class TrainingRepository.
 *
 * @extends AbstractRepository<Training>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TrainingRepository extends AbstractRepository implements TrainingRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Training::class);
    }
}
