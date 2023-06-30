<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Devscast\Bundle\DddBundle\Domain\Exception\SafeMessageException;

/**
 * class PasswordNotSetException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class PasswordNotSetException extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

    public function __construct(
        string $message = 'authentication.exceptions.password_not_set',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
