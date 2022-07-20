<?php

declare(strict_types=1);

namespace Domain\Content\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class EducationLevel.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class EducationLevel
{
    final public const LEVELS = ['beginner', 'intermediate', 'advance'];
    private string $level = 'beginner';

    private function __construct(string $level)
    {
        Assert::inArray($level, self::LEVELS);
        $this->level = $level;
    }

    public function __toString(): string
    {
        return $this->level;
    }

    public static function beginner(): self
    {
        return new self('beginner');
    }

    public static function intermediate(): self
    {
        return new self('intermediate');
    }

    public static function advanced(): self
    {
        return new self('advanced');
    }

    public static function fromString(string $level): self
    {
        return new self($level);
    }

    public function equals(self|string $type): bool
    {
        if ($type instanceof self) {
            return $type->level === $this->level;
        }

        return $this->level === $type;
    }
}
