<?php

declare(strict_types=1);

namespace Domain\Authentication\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class Username.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Username implements \Stringable
{
    private const MIN_LENGTH = 5;
    private const MAX_LENGTH = 30;
    private const FORMAT = '/^(\w(?:(?:\w|(?:\.(?!\.))){5,30}(?:\w))?)$/';

    private readonly string $username;

    private function __construct(string $username)
    {
        Assert::notEmpty($username, 'authentication.validations.empty_username');
        Assert::minLength($username, self::MIN_LENGTH, 'authentication.validations.short_username');
        Assert::maxLength($username, self::MAX_LENGTH, 'authentication.validations.long_username');
        Assert::regex($username, self::FORMAT, 'authentication.validations.invalid_username_pattern');

        $this->username = $username;
    }

    public function __toString()
    {
        return $this->username;
    }

    public static function fromString(string $username): self
    {
        return new self($username);
    }

    public function equals(string|self $username): bool
    {
        if ($username instanceof self) {
            return $this->username === $username->username;
        }

        return $this->username === $username;
    }
}
