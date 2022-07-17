<?php

declare(strict_types=1);

namespace Domain\Shared\Repository;

/**
 * Interface CleanableRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface CleanableRepositoryInterface
{
    public function clean(): int;
}
