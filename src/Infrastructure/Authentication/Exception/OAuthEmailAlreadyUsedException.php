<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class OAuthEmailAlreadyUsedException
 * @package Infrastructure\Authentication\Exception
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OAuthEmailAlreadyUsedException extends CustomUserMessageAuthenticationException
{
    public function __construct()
    {
        parent::__construct(message: "authentication.exceptions.oauth_email_already_used");
    }
}
