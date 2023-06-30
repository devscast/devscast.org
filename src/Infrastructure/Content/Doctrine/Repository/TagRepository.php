<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Tag;
use Domain\Content\Exception\DuplicateTagException;
use Domain\Content\Repository\TagRepositoryInterface;

/**
 * class TagRepository.
 *
 * @extends AbstractRepository<Tag>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function save(object $entity, bool $flush = true): void
    {
        try {
            parent::save($entity, $flush);
        } catch (UniqueConstraintViolationException $e) {
            throw new DuplicateTagException(previous: $e);
        }
    }
}
