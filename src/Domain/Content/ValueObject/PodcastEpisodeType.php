<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class PodcastEpisodeType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PodcastEpisodeType implements \Stringable
{
    final public const TYPES = ['Full', 'Trailer', 'Bonus'];
    private string $type = 'Full';

    private function __construct(string $type)
    {
        Assert::inArray($type, self::TYPES);
        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public static function full(): self
    {
        return new self('Full');
    }

    public static function trailer(): self
    {
        return new self('Trailer');
    }

    public static function bonus(): self
    {
        return new self('Bonus');
    }

    public static function fromString(string $type): self
    {
        return new self($type);
    }

    public function equals(self|string $type): bool
    {
        if ($type instanceof self) {
            return $type->type === $this->type;
        }

        return $this->type === $type;
    }
}
