<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Erreur renvoyée lorsque l'on ne trouve pas
 * d'utilisateur correspondant à la réponse de l'OAUTH.
 *
 * Class UserOAuthNotFoundException
 * @package Infrastructure\Authentication\Exception
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserOAuthNotFoundException extends AuthenticationException
{
    private ResourceOwnerInterface $resourceOwner;

    /**
     * UserOauthNotFoundException constructor.
     * @param ResourceOwnerInterface $resourceOwner
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function __construct(ResourceOwnerInterface $resourceOwner)
    {
        $this->resourceOwner = $resourceOwner;
    }

    public function getResourceOwner(): ResourceOwnerInterface
    {
        return $this->resourceOwner;
    }
}
