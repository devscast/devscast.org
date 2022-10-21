<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface AttachmentRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface AttachmentRepositoryInterface extends DataRepositoryInterface
{
    public function findYearsMonths(): array;

    public function findForPath(string $path): array;

    public function findLatest(): array;

    public function search(string $query): array;
}
