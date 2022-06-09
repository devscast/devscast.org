<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Domain\Shared\Exception\SafeMessageException;

/**
 * Class ResetPasswordOngoingException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordOngoingException extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

    public function __construct(
        string $message = 'authentication.exceptions.reset_password_ongoing_request',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
