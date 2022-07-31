<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\ResendTwoFactorCodeCommand;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Email\Generator\CodeGeneratorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\RateLimiter\Exception\RateLimitExceededException;
use Symfony\Component\RateLimiter\RateLimiterFactory;

/**
 * Class ResendTwoFactorCodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class ResendTwoFactorCodeHandler
{
    public function __construct(
        private readonly CodeGeneratorInterface $codeGenerator,
        private readonly RateLimiterFactory $resendTwoFactorCodeLimiter
    ) {
    }

    /**
     * @throws RateLimitExceededException
     */
    public function __invoke(ResendTwoFactorCodeCommand $command): void
    {
        $limiter = $this->resendTwoFactorCodeLimiter->create($command->ip);
        $limiter->consume()->ensureAccepted();
        $this->codeGenerator->generateAndSend($command->user);
    }
}
