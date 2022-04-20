<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Security;

use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContextInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Condition\TwoFactorConditionInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

/**
 * Class TwoFactorCondition.
 * To avoid doing a 2fa check when the user connects with a link login.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TwoFactorCondition implements TwoFactorConditionInterface
{
    public function shouldPerformTwoFactorAuthentication(AuthenticationContextInterface $context): bool
    {
        if ($context->getPassport() instanceof SelfValidatingPassport) {
            return false;
        }

        return true;
    }
}
