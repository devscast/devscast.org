<?php

declare(strict_types=1);

namespace Application\Authentication\Handler;

use Application\Authentication\Command\Resend2FACodeCommand;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Email\Generator\CodeGeneratorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\RateLimiter\Exception\RateLimitExceededException;
use Symfony\Component\RateLimiter\RateLimiterFactory;

/**
 * Class Resend2FACodeHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsMessageHandler]
final class Resend2FACodeHandler
{
    public function __construct(
        private readonly CodeGeneratorInterface $codeGenerator,
        private readonly RateLimiterFactory $resend2FACodeLimiter
    ) {
    }

    /**
     * @throws RateLimitExceededException
     */
    public function __invoke(Resend2FACodeCommand $command): void
    {
        $limiter = $this->resend2FACodeLimiter->create($command->ip);
        $limiter->consume(1)->ensureAccepted();
        $this->codeGenerator->generateAndSend($command->user);
    }
}
