<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Domain\Content\Entity\Content;
use Domain\Content\Entity\Tag;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface ContentRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface ContentRepositoryInterface extends DataRepositoryInterface
{
    public function resetTopPromotedContent(string $type): bool;

    public function findContents(string $type): array;

    public function findContent(string $type, int $id): ?Content;

    public function findFeatured(string $type): array;

    public function findTopPromoted(string $type): array;

    public function findLatestContents(string $type, int $limit): array;

    public function findContentsByTag(string $type, Tag $tag): array;

    public function findByTag(Tag $tag): array;
}
