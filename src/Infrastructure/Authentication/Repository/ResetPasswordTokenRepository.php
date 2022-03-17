<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Repository\ResetPasswordTokenRepository as ResetPasswordTokenRepositoryInterface;
use Infrastructure\Shared\Doctrine\ServiceEntityRepository;

/**
 * Class ResetPasswordTokenRepository
 * @package Infrastructure\Authentication\Repository
 * @author bernard-ng <bernard@devscast.tech>
 */
class ResetPasswordTokenRepository extends ServiceEntityRepository implements ResetPasswordTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordToken::class);
    }
}
