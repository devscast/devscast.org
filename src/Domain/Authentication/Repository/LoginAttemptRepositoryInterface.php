<?php

declare(strict_types=1);

namespace Domain\Authentication\Repository;

use Domain\Authentication\Entity\User;
use Domain\Shared\Repository\DataRepositoryInterface;

/**
 * Interface LoginAttemptRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface LoginAttemptRepositoryInterface extends DataRepositoryInterface
{
    public function deleteAttemptsFor(User $user): void;

    public function countRecentFor(User $user, int $minutes): int;
}
