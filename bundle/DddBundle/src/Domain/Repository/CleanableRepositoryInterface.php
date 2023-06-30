<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Domain\Repository;

/**
 * interface CleanableRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface CleanableRepositoryInterface
{
    public function clean(): int;
}
