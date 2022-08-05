<?php

declare(strict_types=1);

namespace Tests\Domain\Authentication\ValueObject;

use Domain\Authentication\ValueObject\Gender;
use PHPUnit\Framework\TestCase;

final class GenderTest extends TestCase
{
    public function testInstanceValueCastToStringValue(): void
    {
        $validGenders = ['M', 'F', 'O'];

        foreach ($validGenders as $name) {
            $this->assertSame($name, (string) Gender::fromString($name));
        }
    }

    public function testInstanceValueHasExceptedOptions(): void
    {
        $this->assertSame(Gender::VALUES, ['M', 'F', 'O']);
    }

    public function testInstanceAndValueAreEquals(): void
    {
        $this->assertSame(true, Gender::female()->equals('F'));
        $this->assertSame(true, Gender::male()->equals('M'));
        $this->assertSame(true, Gender::queer()->equals('O'));
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = Gender::fromString('F');
        $b = Gender::fromString('F');
        $this->assertSame(true, $a->equals($b));
        $this->assertSame(true, $b->equals($a));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = Gender::fromString('F');
        $b = Gender::fromString('M');
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testStringValueEqualsInstanceValue(): void
    {
        $a = Gender::fromString('O');
        $this->assertSame(true, $a->equals('O'));
    }
}
