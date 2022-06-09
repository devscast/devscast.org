<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Domain\Shared\Exception\SafeMessageException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class UserOAuthNotFoundException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserOAuthNotFoundException extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

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
