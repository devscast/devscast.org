<?php

declare(strict_types=1);

namespace Domain\Content\Exception;

use Devscast\Bundle\DddBundle\Domain\Exception\SafeMessageException;

/**
 * class InvalidSlugException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class InvalidSlugException extends SafeMessageException
{
    protected string $messageDomain = 'content';

    public function __construct(
        string $message = 'content.exceptions.invalid_slug',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
