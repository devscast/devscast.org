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
    final public const VALUES = ['beginner', 'intermediate', 'advanced'];
    final public const CHOICES = [
        'content.value_object.education_level.beginner' => 'beginner',
        'content.value_object.education_level.intermediate' => 'intermediate',
        'content.value_object.education_level.advanced' => 'advanced'
    ];
    private string $education_level = 'beginner';

    private function __construct(string $level)
    {
        Assert::inArray($level, self::VALUES);
        $this->education_level = $level;
    }

    public function __toString(): string
    {
        return $this->education_level;
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->education_level, self::CHOICES));
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
            return $type->education_level === $this->education_level;
        }

        return $this->education_level === $type;
    }
}
