<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Domain\Authentication\Entity\User;
use Domain\Content\Entity\Content;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface ContentViewRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface ContentViewRepositoryInterface extends DataRepositoryInterface
{
    public function isContentAlreadyViewed(Content $target, string $ip, ?User $owner): bool;
}
