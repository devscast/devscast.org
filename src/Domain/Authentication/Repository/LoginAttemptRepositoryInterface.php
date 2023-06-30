<?php

declare(strict_types=1);

namespace Domain\Authentication\Repository;

use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Authentication\Entity\User;

/**
 * Interface LoginAttemptRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface LoginAttemptRepositoryInterface extends DataRepositoryInterface
{
    public function deleteAttemptsFor(User $user): void;

    public function countRecentFor(User $user): int;
}
