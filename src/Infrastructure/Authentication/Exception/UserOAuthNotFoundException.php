<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Erreur renvoyée lorsque l'on ne trouve pas
 * d'utilisateur correspondant à la réponse de l'OAUTH.
 *
 * Class UserOAuthNotFoundException
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserOAuthNotFoundException extends AuthenticationException
{
    private ResourceOwnerInterface $resourceOwner;

    /**
     * UserOauthNotFoundException constructor.
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function __construct(ResourceOwnerInterface $resourceOwner)
    {
        $this->resourceOwner = $resourceOwner;
        parent::__construct(message: 'authentication.exceptions.oauth_user_not_found');
    }

    public function getResourceOwner(): ResourceOwnerInterface
    {
        return $this->resourceOwner;
    }
}
