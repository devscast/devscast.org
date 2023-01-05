<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Domain\Content\ValueObject\ContentType;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface ContentRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface ContentRepositoryInterface extends DataRepositoryInterface
{
    public function overrideContentTopPromoted(ContentType $type): bool;

    public function findAllByType(ContentType $type): array;
}
