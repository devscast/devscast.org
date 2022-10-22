<?php

declare(strict_types=1);

namespace Domain\Content\Exception;

use Domain\Shared\Exception\SafeMessageException;

/**
 * class DuplicateTagException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class DuplicateTagException extends SafeMessageException
{
    protected string $messageDomain = 'content';

    public function __construct(
        string $message = 'content.exceptions.duplicate_tag',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
