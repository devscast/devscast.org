<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Authenticator;

use Domain\Authentication\Entity\User;
use Domain\Authentication\Repository\UserRepository;
use Infrastructure\Authentication\Exception\OAuthVerifiedEmailNotFoundException;
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

    public function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User
    {
        if (! ($resourceOwner instanceof FacebookUser)) {
            throw new \RuntimeException('Expecting FacebookUser as the first parameter');
        }

        if (true !== ($resourceOwner->toArray()['email_verified'] ?? null)) {
            throw new OAuthVerifiedEmailNotFoundException();
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
