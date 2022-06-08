<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Authenticator;

use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepositoryInterface;
use Infrastructure\Authentication\Exception\OAuthVerifiedEmailNotFoundException;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class GoogleAuthenticator.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class GoogleAuthenticator extends AbstractOAuthAuthenticator
{
    protected string $serviceName = 'google';

    public function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepositoryInterface $repository): ?User
    {
        if (! ($resourceOwner instanceof GoogleUser)) {
            throw new \RuntimeException('Expecting GoogleUser as the first parameter');
        }

        if (true !== ($resourceOwner->toArray()['email_verified'] ?? null)) {
            throw new OAuthVerifiedEmailNotFoundException();
        }

        $user = $repository->findForOauth(
            service: 'google',
            serviceId: strval($resourceOwner->getId()),
            email: $resourceOwner->getEmail()
        );

        if ($user && null === $user->getGoogleId()) {
            $user->setGoogleId(strval($resourceOwner->getId()));
            $this->em->flush();
        }

        return $user;
    }
}
