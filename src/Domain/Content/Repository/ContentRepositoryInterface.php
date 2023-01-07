<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Domain\Content\Entity\Content;
use Domain\Content\Entity\Tag;
use Domain\Content\ValueObject\ContentType;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface ContentRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface ContentRepositoryInterface extends DataRepositoryInterface
{
    public function resetTopPromotedContent(ContentType $type): bool;

    public function findContents(ContentType $type): array;

    public function findContent(ContentType $type, int $id): ?Content;

    public function findFeatured(ContentType $type): array;

    public function findTopPromoted(ContentType $type): array;

    public function findLatestContents(ContentType $type, int $limit): array;

    public function findContentsByTag(ContentType $type, Tag $tag): array;

    public function findByTag(Tag $tag): array;
}
