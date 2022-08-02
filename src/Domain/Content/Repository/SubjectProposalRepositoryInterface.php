<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Domain\Authentication\Entity\User;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface SubjectProposalRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface SubjectProposalRepositoryInterface extends DataRepositoryInterface
{
    public function countRecentFor(User $owner): int;
}
