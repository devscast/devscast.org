<?php

declare(strict_types=1);

namespace Domain\Content\Repository;

use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Authentication\Entity\User;

/**
 * Interface SubjectProposalRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface SubjectProposalRepositoryInterface extends DataRepositoryInterface
{
    public function countRecentFor(User $owner): int;
}
