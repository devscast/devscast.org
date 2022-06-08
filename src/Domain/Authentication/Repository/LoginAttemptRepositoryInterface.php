<?php

declare(strict_types=1);

namespace Domain\Authentication\Repository;

use Domain\Authentication\Entity\User;
use Domain\Shared\Repository\DataRepository;

/**
 * Interface LoginAttemptRepositoryInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface LoginAttemptRepositoryInterface extends DataRepository
{
    public function deleteAttemptsFor(User $user): void;

    public function countRecentFor(User $user, int $minutes): int;
}
