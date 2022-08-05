<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

use Webmozart\Assert\Assert;

/**
 * class SubjectProposalStatus.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class SubjectProposalStatus
{
    final public const VALUES = ['reviewing', 'accepted', 'rejected'];
    private string $status = 'reviewing';

    private function __construct(string $status)
    {
        Assert::inArray($status, self::VALUES);
        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public static function reviewing(): self
    {
        return new self('reviewing');
    }

    public static function rejected(): self
    {
        return new self('rejected');
    }

    public static function accepted(): self
    {
        return new self('accepted');
    }

    public static function fromString(string $status): self
    {
        return new self($status);
    }

    public function equals(self|string $status): bool
    {
        if ($status instanceof self) {
            return $status->status === $this->status;
        }

        return $this->status === $status;
    }
}
