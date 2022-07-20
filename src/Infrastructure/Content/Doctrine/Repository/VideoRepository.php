<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Video;
use Domain\Content\Repository\VideoRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class VideoRepository.
 *
 * @extends AbstractRepository<Video>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class VideoRepository extends AbstractRepository implements VideoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }
}
