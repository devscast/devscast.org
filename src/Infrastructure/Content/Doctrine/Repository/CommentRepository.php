<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Comment;
use Domain\Content\Repository\CommentRepositoryInterface;

/**
 * class CommentRepository.
 *
 * @extends AbstractRepository<Comment>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CommentRepository extends AbstractRepository implements CommentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }
}
