<?php

declare(strict_types=1);

namespace Domain\Content\Exception;

use Domain\Shared\Exception\SafeMessageException;

/**
 * class ContentScheduleDateMustBeInFutureException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentScheduleDateMustBeInFutureException extends SafeMessageException
{
    protected string $messageDomain = 'content';

    public function __construct(
        string $message = 'content.exceptions.content_schedule_date_must_be_in_future',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
