<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Devscast\Bundle\DddBundle\Domain\Exception\SafeMessageException;

/**
 * Class OAuthVerifiedEmailNotFoundException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class OAuthVerifiedEmailNotFoundException extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

    public function __construct(
        string $message = 'authentication.exceptions.oauth_verified_email_not_found',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
