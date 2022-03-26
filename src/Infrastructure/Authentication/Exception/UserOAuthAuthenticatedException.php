<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Domain\Authentication\Entity\User;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class UserAuthenticatedException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserOAuthAuthenticatedException extends AuthenticationException
{
    private User $user;
    private ResourceOwnerInterface $resourceOwner;

    /**
     * UserAuthenticatedException constructor.
     *
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function __construct(User $user, ResourceOwnerInterface $resourceOwner)
    {
        $this->user = $user;
        $this->resourceOwner = $resourceOwner;
        parent::__construct(message: 'authentication.exceptions.oauth_authenticated');
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getResourceOwner(): ResourceOwnerInterface
    {
        return $this->resourceOwner;
    }
}
