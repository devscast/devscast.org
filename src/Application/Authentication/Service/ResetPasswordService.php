<?php

declare(strict_types=1);

namespace Application\Authentication\Service;

use Domain\Authentication\Entity\ResetPasswordToken;
use Domain\Authentication\Exception\ResetPasswordTokenExpiredException;
use Domain\Authentication\Repository\ResetPasswordTokenRepositoryInterface;

/**
 * Class ResetPasswordService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordService
{
    private const EXPIRE_IN = 30;

    public function __construct(
        private readonly ResetPasswordTokenRepositoryInterface $tokenRepository,
    ) {
    }

    public function findToken(string $token): ResetPasswordToken
    {
        /** @var ResetPasswordToken|null $token */
        $token = $this->tokenRepository->findOneByToken($token);
        if (null === $token || $token->isExpired(interval: self::EXPIRE_IN)) {
            throw new ResetPasswordTokenExpiredException();
        }

        return $token;
    }
}
