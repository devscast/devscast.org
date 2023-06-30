<?php

declare(strict_types=1);

namespace Domain\Content\Exception;

use Devscast\Bundle\DddBundle\Domain\Exception\SafeMessageException;

/**
 * class SubjectProposalLimitReachedException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class SubjectProposalLimitReachedException extends SafeMessageException
{
    protected string $messageDomain = 'content';

    public function __construct(
        string $message = 'content.exceptions.subject_proposal_limit_reached',
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $messageData, $code, $previous);
    }
}
