<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Domain\Authentication\Entity\User;
use Domain\Shared\Exception\SafeMessageException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class UserOAuthAuthenticatedException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserOAuthAuthenticatedException extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

    public function __construct(
        private readonly User $user,
        private readonly ResourceOwnerInterface $resourceOwner
    ) {
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
