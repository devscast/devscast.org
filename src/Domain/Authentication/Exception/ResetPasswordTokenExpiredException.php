<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Devscast\Bundle\DddBundle\Domain\Exception\SafeMessageException;

/**
 * Class ResetPasswordTokenExpiredException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ResetPasswordTokenExpiredException extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

    public function __construct(
        string $message = 'authentication.exceptions.reset_password_token_expired',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
