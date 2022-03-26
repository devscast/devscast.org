<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Repository\ResetPasswordTokenRepository as ResetPasswordTokenRepositoryInterface;
use Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * Class ResetPasswordTokenRepository.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordTokenRepository extends AbstractRepository implements ResetPasswordTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordToken::class);
    }
}
