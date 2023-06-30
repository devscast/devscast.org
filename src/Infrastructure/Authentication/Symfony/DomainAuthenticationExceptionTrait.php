<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony;

use Devscast\Bundle\DddBundle\Domain\Exception\SafeMessageException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * trait DomainAuthenticationExceptionTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait DomainAuthenticationExceptionTrait
{
    public function throwDomainException(SafeMessageException $exception): never
    {
        $custom = new CustomUserMessageAuthenticationException(previous: $exception);
        $custom->setSafeMessage($exception->getMessageKey(), $exception->getMessageData());
        throw $custom;
    }
}
