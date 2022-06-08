<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Authenticator;

use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepositoryInterface;
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class FacebookAuthenticator.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FacebookAuthenticator extends AbstractOAuthAuthenticator
{
    protected string $serviceName = 'facebook';

    public function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepositoryInterface $repository): ?User
    {
        if (! ($resourceOwner instanceof FacebookUser)) {
            throw new \RuntimeException('Expecting FacebookUser as the first parameter');
        }

        $user = $repository->findForOauth(
            service: 'facebook',
            serviceId: strval($resourceOwner->getId()),
            email: $resourceOwner->getEmail()
        );

        if ($user && null === $user->getFacebookId()) {
            $user->setFacebookId(strval($resourceOwner->getId()));
            $this->em->flush();
        }

        return $user;
    }
}
