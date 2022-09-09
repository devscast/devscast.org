<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Domain\Shared\Exception\SafeMessageException;

/**
 * class InvalidRegistrationConfirmationToken.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class InvalidRegistrationConfirmationToken extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

    public function __construct(
        string $message = 'authentication.exceptions.invalid_registration_confirmation_token',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
