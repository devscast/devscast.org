<?php

declare(strict_types=1);

namespace Domain\Authentication\ValueObject;

use Webmozart\Assert\Assert;

class RssUrl implements \Stringable
{
    public const FORMAT = '/^https?:\/\/.*\.(?:rss|xml)$/';

    private readonly string $rss_url;

    public function __construct(string $url)
    {
        Assert::nullOrRegex($url, self::FORMAT, 'authentication.validations.invalid_rss_url_pattern');
        Assert::nullOrLessThanEq(strlen($url), 255, 'authentication.validations.rss_url_too_long');
        $this->rss_url = $url;
    }

    public function __toString(): string
    {
        return $this->rss_url;
    }

    public static function fromString(string $url): self
    {
        return new self($url);
    }

    public function equals(string|self $url): bool
    {
        if ($url instanceof self) {
            return $this->rss_url === $url->rss_url;
        }

        return $this->rss_url === $url;
    }
}