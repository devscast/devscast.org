<?php

declare(strict_types=1);

namespace Domain\Authentication\Repository;

use Domain\Authentication\Entity\User;
use Domain\Shared\Repository\DataRepository;

/**
 * Interface UserRepository.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface UserRepository extends DataRepository
{
    public function findForOauth(string $service, ?string $serviceId, ?string $email): ?User;

    public function findOneByEmail(string $email): ?User;
}
