<?php

declare(strict_types=1);

namespace Domain\Authentication\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class Gender.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Gender implements \Stringable
{
    public const GENDERS = ['M', 'F', 'O'];
    public const GENDERS_CHOICES = [
        'M' => 'M',
        'F' => 'F',
        'O' => 'O',
    ];

    private readonly string $gender;

    private function __construct(string $gender)
    {
        Assert::inArray($gender, self::GENDERS);
        $this->gender = $gender;
    }

    public function __toString(): string
    {
        return $this->gender;
    }

    public static function fromString(string $gender): self
    {
        return new self($gender);
    }

    public static function male(): self
    {
        return new self('M');
    }

    public static function female(): self
    {
        return new self('F');
    }

    public static function queer(): self
    {
        return new self('O');
    }

    public function equals(string|self $gender): bool
    {
        if ($gender instanceof self) {
            return $this->gender === $gender->gender;
        }

        return $this->gender === $gender;
    }
}
