<?php

declare(strict_types=1);

namespace Domain\Authentication\Repository;

use Devscast\Bundle\DddBundle\Domain\Repository\CleanableRepositoryInterface;
use Devscast\Bundle\DddBundle\Domain\Repository\DataRepositoryInterface;
use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Entity\User;

/**
 * Interface ResetPasswordRepository.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface ResetPasswordTokenRepositoryInterface extends DataRepositoryInterface, CleanableRepositoryInterface
{
    public function findFor(User $user): ?ResetPasswordToken;

    public function findOneByToken(string $token): ?ResetPasswordToken;
}
