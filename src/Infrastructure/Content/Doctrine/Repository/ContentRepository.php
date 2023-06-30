<?php

declare(strict_types=1);

namespace Infrastructure\Content\Doctrine\Repository;

use Devscast\Bundle\DddBundle\Infrastructure\Doctrine\Repository\AbstractRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Content\Entity\Content;
use Domain\Content\Entity\Post;
use Domain\Content\Entity\Tag;
use Domain\Content\Repository\ContentRepositoryInterface;
use Domain\Content\ValueObject\ContentStatus;

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

    /**
     * @phpstan-param class-string<Content> $type
     */
    public function resetTopPromotedContent(string $type): bool
    {
        return boolval(
            $this->createQueryBuilder('c')
                ->update(Content::class)
                ->set('c.is_top_promoted', false)
                ->where('c.is_top_promoted = TRUE')
                ->andWhere('c INSTANCE OF :type')
                ->setParameter('type', $this->getEntityManager()->getClassMetadata($type))
                ->getQuery()
                ->execute()
        );
    }

    /**
     * @phpstan-param class-string<Content> $type
     */
    public function findContents(string $type): array
    {
        /** @var Content[] $result */
        $result = $this->findContentsQueryBuilder($type)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @phpstan-param class-string<Content> $type
     */
    public function findContent(string $type, int $id): ?Content
    {
        /** @var Content|null $result */
        $result = $this->findContentsQueryBuilder($type)
            ->andwhere('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @phpstan-param class-string<Content> $type
     */
    public function findFeatured(string $type): array
    {
        /** @var Content[] $result */
        $result = $this->findContentsQueryBuilder($type)
            ->andWhere('c.is_featured = TRUE')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @phpstan-param class-string<Content> $type
     */
    public function findTopPromoted(string $type): array
    {
        /** @var Content[] $result */
        $result = $this->findContentsQueryBuilder($type)
            ->andWhere('c.is_top_promoted = TRUE')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @phpstan-param class-string<Content> $type
     */
    public function findLatestContents(string $type, int $limit): array
    {
        /** @var Content[] $result */
        $result = $this->findContentsQueryBuilder($type)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @phpstan-param class-string<Content> $type
     */
    public function findContentsByTag(string $type, Tag $tag): array
    {
        return [];
    }

    public function findByTag(Tag $tag): array
    {
        return [];
    }

    /**
     * @phpstan-param class-string<Content> $type
     */
    private function findContentsQueryBuilder(string $type = Post::class): QueryBuilder
    {
        return $this->findAllContentsQueryBuilder()
            ->andWhere('c INSTANCE OF :type')
            ->setParameter('type', $this->getEntityManager()->getClassMetadata($type));
    }

    private function findAllContentsQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->where('c.status.status = :status AND c.is_online = TRUE')
            ->andWhere('c.created_at <= CURRENT_TIMESTAMP() OR c.scheduled_at <= CURRENT_TIMESTAMP()')
            ->setParameter('status', (string) ContentStatus::published())
            ->orderBy('c.created_at', 'DESC');
    }
}
