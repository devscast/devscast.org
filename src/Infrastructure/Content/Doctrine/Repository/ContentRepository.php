<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Content;
use Domain\Content\Entity\Tag;
use Domain\Content\Repository\ContentRepositoryInterface;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * class ContentRepository.
 *
 * @extends AbstractRepository<Content>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentRepository extends AbstractRepository implements ContentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }

    public function resetTopPromotedContent(ContentType $type): bool
    {
        return boolval(
            $this->createQueryBuilder('c')
                ->update(Content::class)
                ->set('c.is_top_promoted', false)
                ->where('c.is_top_promoted = TRUE')
                ->andWhere('c.content_type.content_type = :type')
                ->setParameter('type', (string) $type)
                ->getQuery()
                ->execute()
        );
    }

    public function findContents(ContentType $type): array
    {
        /** @var $result Content[] */
        $result = $this->findContentsQueryBuilder($type)
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findContent(ContentType $type, int $id): ?Content
    {
        /** @var Content|null $result */
        $result = $this->findContentsQueryBuilder($type)
            ->andwhere('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findFeatured(ContentType $type): array
    {
        /** @var Content[] $result */
        $result = $this->findContentsQueryBuilder($type)
            ->andWhere('c.is_featured = TRUE')
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findTopPromoted(ContentType $type): array
    {
        /** @var Content[] $result */
        $result = $this->findContentsQueryBuilder($type)
            ->andWhere('c.is_top_promoted = TRUE')
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findLatestContents(ContentType $type, int $limit): array
    {
        /** @var Content[] $result */
        $result = $this->findContentsQueryBuilder($type)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findContentsByTag(ContentType $type, Tag $tag): array
    {
        return [];
    }

    public function findByTag(Tag $tag): array
    {
        return [];
    }

    private function findContentsQueryBuilder(?ContentType $type = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.status.status = :status AND c.is_online = TRUE')
            ->andWhere('c.created_at <= CURRENT_TIMESTAMP() OR c.scheduled_at <= CURRENT_TIMESTAMP()')
            ->setParameter('status', (string) ContentStatus::published())
            ->orderBy('c.created_at', 'DESC');

        if ($type !== null) {
            $qb->andWhere('c.content_type.content_type = :type')
                ->setParameter('type', (string) $type);
        }

        return $qb;
    }
}
