<?php

declare(strict_types=1);

namespace Domain\Authentication\Exception;

use Devscast\Bundle\DddBundle\Domain\Exception\SafeMessageException;

/**
 * Class TooManyLoginAttemptsException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TooManyLoginAttemptsException extends SafeMessageException
{
    protected string $messageDomain = 'authentication';

    public function __construct(
        string $message = 'authentication.exceptions.too_many_login_attempts',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
