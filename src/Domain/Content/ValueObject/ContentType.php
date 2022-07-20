<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

use Webmozart\Assert\Assert;

/**
 * class ContentType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class ContentType
{
    final public const TYPES = ['podcast', 'post', 'video'];
    private string $type = 'post';

    private function __construct(string $type)
    {
        Assert::inArray($type, self::TYPES);
        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public static function podcast(): self
    {
        return new self('podcast');
    }

    public static function video(): self
    {
        return new self('video');
    }

    public static function post(): self
    {
        return new self('post');
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
