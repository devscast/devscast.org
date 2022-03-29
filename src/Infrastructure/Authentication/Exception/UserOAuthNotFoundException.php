<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Exception\UserOAuthNotFoundException as UserOAuthNotFoundExceptionInterface;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Erreur renvoyée lorsque l'on ne trouve pas
 * d'utilisateur correspondant à la réponse de l'OAUTH.
 *
 * Class UserOAuthNotFoundException
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserOAuthNotFoundException extends CustomUserMessageAuthenticationException implements UserOAuthNotFoundExceptionInterface
{
    /**
     * UserOauthNotFoundException constructor.
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function __construct(
        private readonly ResourceOwnerInterface $resourceOwner
    ) {
        parent::__construct(message: 'authentication.exceptions.oauth_user_not_found');
    }

    public function getResourceOwner(): ResourceOwnerInterface
    {
        return $this->resourceOwner;
    }
}
