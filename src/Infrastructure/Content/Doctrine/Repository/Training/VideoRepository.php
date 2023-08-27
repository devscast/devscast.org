<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository\Training;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Training\Video;
use Domain\Content\Repository\Training\VideoRepositoryInterface;

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
